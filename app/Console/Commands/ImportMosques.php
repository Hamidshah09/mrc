<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Mousque;

class ImportMosques extends Command
{
    protected $signature = 'import:mosques {--file=mosques_ready_for_import.csv}';
    protected $description = 'Import mosques from cleaned CSV (sector_id based)';

    public function handle()
    {
        $filePath = storage_path('app/' . $this->option('file'));

        if (!file_exists($filePath)) {
            $this->error("CSV file not found: {$filePath}");
            return Command::FAILURE;
        }

        $handle = fopen($filePath, 'r');
        $header = fgetcsv($handle);

        DB::beginTransaction();

        try {
            while (($row = fgetcsv($handle)) !== false) {
                $data = array_combine($header, $row);

                // Mandatory fields check
                if (
                    empty($data['name']) ||
                    empty($data['address']) ||
                    empty($data['sector_id'])
                ) {
                    Log::warning('Skipped mosque due to missing required data', $data);
                    continue;
                }

                Mousque::updateOrCreate(
                    [
                        // Natural uniqueness: same mosque name in same sector
                        'name'       => trim($data['name']),
                        'sector_id'  => (int) $data['sector_id'],
                    ],
                    [
                        'address'    => trim($data['address']),
                        'sub_sector' => $data['sub_sector'] ?: null,
                        'location'   => trim($data['location']),
                        'sect'       => $this->normalizeSect($data['sect']),
                        'status'     => (int) ($data['status'] ?? 1),
                    ]
                );
            }

            DB::commit();
            fclose($handle);

            $this->info('Mosques imported successfully.');
            return Command::SUCCESS;

        } catch (\Throwable $e) {
            DB::rollBack();
            fclose($handle);

            Log::critical('Mosque import failed', [
                'error' => $e->getMessage(),
            ]);

            $this->error('Import failed. Check laravel.log for details.');
            return Command::FAILURE;
        }
    }

    /**
     * Ensure enum safety for `sect`
     */
    private function normalizeSect(?string $sect): string
    {
        return match (trim((string) $sect)) {
            'Barelvi'       => 'Barelvi',
            'Deobandi'      => 'Deobandi',
            'Ahl-e-Hadith'  => 'Ahl-e-Hadith',
            'Shia'          => 'Shia',
            default         => 'Other',
        };
    }
}
