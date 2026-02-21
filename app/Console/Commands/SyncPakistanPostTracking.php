<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SyncPakistanPostTracking extends Command
{
    protected $signature = 'postal:sync-tracking';
    protected $description = 'Sync Pakistan Post tracking for in-transit articles';

    public function handle()
    {
        $this->info('Starting Pakistan Post tracking sync...');

        // ---- 1. Get all In-Transit postal services ----
        $postalServices = DB::table('postalservice')
            ->where('status_id', 6) // Received in GPO
            ->whereNotNull('article_number')
            ->get();

        foreach ($postalServices as $service) {

            $this->info("Tracking {$service->article_number}");

            $trackingData = $this->fetchTracking($service->article_number);

            if (!$trackingData || empty($trackingData['events'])) {
                continue;
            }

            $this->storeHistory(
                $trackingData['events'],
                $service->id,
                $service->user_id
            );
            $this->info("Updated tracking history for {$service->article_number}");
        }

        $this->info('Tracking sync completed.');
    }

    // --------------------------------------------------

    private function fetchTracking(string $trackingId): ?array
    {
        $url = "https://ep.gov.pk/emtts/EPTrack_Live.aspx?ArticleIDz=" . urlencode($trackingId);

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_USERAGENT      => 'Mozilla/5.0',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT        => 30,
        ]);

        $html = curl_exec($ch);
        curl_close($ch);

        if (!$html) {
            return null;
        }

        libxml_use_internal_errors(true);
        $dom = new \DOMDocument();
        $dom->loadHTML($html);
        libxml_clear_errors();

        $xpath = new \DOMXPath($dom);

        $rows = $xpath->query("//div[@id='TrackDetailDiv']//table//tr");

        $events = [];
        $currentDate = null;

        foreach ($rows as $row) {

            $dateNode = $xpath->query(".//div[contains(@class,'date-heading')]", $row);
            if ($dateNode->length > 0) {
                $currentDate = trim($dateNode->item(0)->textContent);
                continue;
            }

            $cells = $row->getElementsByTagName('td');
            if ($cells->length === 4) {
                $events[] = [
                    'date'     => $currentDate,
                    'time'     => trim($cells->item(1)->textContent),
                    'location' => trim($cells->item(2)->textContent),
                    'status'   => trim($cells->item(3)->textContent),
                ];
            }
        }

        return ['events' => $events];
    }

    // --------------------------------------------------

    private function storeHistory(array $events, int $postalServiceId, ?int $userId)
    {
        foreach ($events as $event) {

            $text = strtolower(trim($event['status']));

            // Extract first word only
            $firstWord = strtok($text, ' ');

            switch ($firstWord) {
                case 'dispatch':
                    $statusId = 5; // Dispatched
                    break;

                case 'delivered':
                    $statusId = 3; // Delivered
                    break;

                case 'undelivered':
                    $statusId = 7; // Returned / Undelivered
                    break;

                case 'received':
                    $statusId = 6; // Received at GPO (if you use it)
                    break;

                default:
                    continue 2; // Skip unknown statuses safely
            }
            $createdAt = Carbon::createFromFormat(
                'F d, Y h:i A',
                $event['date'] . ' ' . $event['time']
            );

            $exists = DB::table('postalhistory')
                ->where('postalservice_id', $postalServiceId)
                ->where('status_id', $statusId)
                ->where('created_at', $createdAt)
                ->exists();

            if ($exists) {
                continue;
            }

            DB::table('postalhistory')->insert([
                'postalservice_id' => $postalServiceId,
                'status_id'        => $statusId,
                'user_id'          => $userId,
                'created_at'       => $createdAt,
                'updated_at'       => now(),
            ]);

            // ---- Update main table if Delivered ----
            if ($statusId === 3) {
                DB::table('postalservice')
                    ->where('id', $postalServiceId)
                    ->update([
                        'status_id'  => 3,
                        'updated_at' => now(),
                    ]);
            }
        }
    }
}
