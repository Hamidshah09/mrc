<?php

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdateCounters extends Command
{
    protected $signature = 'counters:update';
    protected $description = 'Fetch counters from Python API and cache them';

    public function handle()
    {
        Log::info('UpdateCounters command executed at ' . now());
        $apiUrl = config('services.api.url');
        try {
            $response = Http::get($apiUrl.'/statistics/check');

            if ($response->successful()) {
                $data = $response->json();
                $marriageCertificates = 4523; // Or fetch from DB

                $finalData = [
                    'marriage_certificates' => $marriageCertificates,
                    'domiciles' => $data['domicile'] ?? 0,
                    'driving_permits' => $data['idp'] ?? 0,
                ];

                Cache::put('counters', $finalData, now()->addHour());

                $this->info('Counters updated successfully.');
            } else {
                $this->error('Failed to fetch Python API data.');
            }
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
}

