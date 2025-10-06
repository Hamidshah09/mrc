<?php

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UpdateCounters extends Command
{
    protected $signature = 'counters:update';
    protected $description = 'Fetch counters from Python API and cache them';

    public function handle()
    {
        Log::info('UpdateCounters command executed at ' . now());
        $apiUrl = config('services.api.url');
        try {
            $response = Http::timeout(60) // 60 seconds
                        ->get($this->apiUrl.'/domicile/statistics/check');

            if ($response->successful()) {
                $data = $response->json();

                $marriageCertificates = 4523; // Or DB::table(...)->count();
                $mrc_count = DB::table('mrc_status')->count();
                $marriageCertificates = $marriageCertificates + $mrc_count;
                $finalData = [
                    'marriage_certificates' => $marriageCertificates,
                    'domiciles' => $data['domicile'] ?? 0,
                    'driving_permits' => $data['idp'] ?? 0,
                ];
                \Log::info('Fetched stats from API', $finalData);
                // \Log::info('Cache value after storing', Cache::get('counters'));
                // Save in cache for 1 hour
                Cache::put('counters', $finalData, now()->addHour());
            } else {
                return ['error' => 'Python API error'];
            }
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
}

