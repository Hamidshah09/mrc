<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CitiesSeeder extends Seeder
{
    public function run(): void
    {
        $files = [
            storage_path('app/districts.csv'),
            storage_path('app/tehsils.csv'),
        ];

        $cities = collect();

        foreach ($files as $file) {
            if (!File::exists($file)) {
                continue;
            }

            $rows = array_map('str_getcsv', file($file));

            foreach ($rows as $index => $row) {
                // Skip header row
                if ($index === 0 && !is_numeric($row[0])) {
                    continue;
                }

                // Column 1 = city name
                if (!empty($row[1])) {
                    $cities->push(trim($row[1]));
                }
            }
        }

        $uniqueCities = $cities
            ->filter()
            ->unique(fn ($name) => strtolower($name))
            ->values();

        foreach ($uniqueCities as $city) {
            DB::table('cities')->updateOrInsert(
                ['name' => $city],
            );
        }
    }
}
