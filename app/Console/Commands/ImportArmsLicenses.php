<?php
namespace App\Console\Commands;

use App\Models\ArmsLicense;
use Illuminate\Console\Command;
use League\Csv\Reader;

class ImportArmsLicenses extends Command
{
    protected $signature = 'import:arms-records';
    protected $description = 'Import arms licenses from CSV file';
    
    public function handle()
    {
        $path = storage_path('app/arms_licenses.csv');

        if (!file_exists($path)) {
            $this->error("CSV file not found at: $path");
            return;
        }

        // ✅ Modern League\Csv usage
        $csv = Reader::createFromPath($path);
        $csv->setHeaderOffset(0); // first line = header row

        $records = $csv->getRecords(); // iterable

        $count = 0;

        foreach ($records as $record) {
            ArmsLicense::updateOrCreate(
                ['id' => $record['id']],
                [
                    'name' => self::nullIfEmpty($record['name'] ?? null),
                    'cnic' => self::nullIfEmpty($record['cnic'] ?? null),
                    'guardian_name' => self::nullIfEmpty($record['guardian_name'] ?? null),
                    'mobile' => self::nullIfEmpty($record['mobile'] ?? null),
                    'weapon_number' => self::nullIfEmpty($record['weapon_number'] ?? null),
                    'license_number' => self::nullIfEmpty($record['license_number'] ?? null),
                    'caliber' => self::nullIfEmpty($record['caliber'] ?? null),
                    'weapon_type' => self::nullIfEmpty($record['weapon_type'] ?? null),
                    'issue_date' => self::parseDate($record['issue_date'] ?? null),
                    'expire_date' => self::parseDate($record['expire_date'] ?? null),
                    'address' => self::nullIfEmpty($record['address'] ?? null),
                    'approver_id' => self::nullIfEmpty($record['approver_id'] ?? null),
                ]
            );

            $count++;
        }

        $this->info("✅ Imported {$count} records successfully!");
    }
    private static function nullIfEmpty($value)
    {
        $value = trim((string) $value);
        return ($value === '' || strtoupper($value) === 'NULL') ? null : $value;
    }

    private static function parseDate($value)
    {
        $value = trim((string) $value);
        if ($value === '' || strtoupper($value) === 'NULL') {
            return null;
        }

        // Try to normalize formats like 01/11/2025 or 1-11-25
        $timestamp = strtotime($value);
        return $timestamp ? date('Y-m-d', $timestamp) : null;
    }

}
