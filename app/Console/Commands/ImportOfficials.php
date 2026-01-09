<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\AuqafOfficial;

class ImportOfficials extends Command
{
    protected $signature = 'import:officials {--file=officials_ready_for_import.csv}';
    protected $description = 'Import auqaf officials from cleaned CSV';

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

                // Mandatory fields
                if (
                    empty($data['cnic']) ||
                    empty($data['name']) ||
                    empty($data['position'])
                ) {
                    Log::warning('Skipped official due to missing required fields', $data);
                    continue;
                }

                AuqafOfficial::updateOrCreate(
                    [
                        // CNIC is globally unique
                        'cnic' => trim($data['cnic']),
                    ],
                    [
                        'name'           => trim($data['name']),
                        'father_name'    => $data['father_name'] ?: 'N/A',
                        'position'       => (int) $data['position'],
                        'contact_number' => trim((string) $data['contact_number']),
                        'type'           => trim((string) $data['type']),
                        'mousque_id'     => $data['mousque_id'] ?: null,
                    ]
                );
            }

            DB::commit();
            fclose($handle);

            $this->info('Officials imported successfully.');
            return Command::SUCCESS;

        } catch (\Throwable $e) {
            DB::rollBack();
            fclose($handle);

            Log::critical('Officials import failed', [
                'error' => $e->getMessage(),
            ]);

            $this->error('Import failed. Check laravel.log.');
            return Command::FAILURE;
        }
    }
}
