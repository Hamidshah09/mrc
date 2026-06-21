<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\UnionCouncil;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ImportUnionCouncils extends Command
{
    protected $signature = 'import:union-councils {file}';
    protected $description = 'Import Union Councils and Secretaries from CSV';

    public function handle()
    {
        $file = $this->argument('file');

        if (!file_exists($file)) {
            $this->error("File not found: {$file}");
            return Command::FAILURE;
        }

        $handle = fopen($file, 'r');

        // Skip header row
        fgetcsv($handle);
        $mobile = 1; // Default mobile number for all secretaries
        while (($row = fgetcsv($handle)) !== false) {

            
            $unionCouncilName = trim($row[0]);

            if (!$unionCouncilName) {
                continue;
            }

            // Create or update union council
            UnionCouncil::updateOrCreate(
                ['name' => $unionCouncilName],
            );

            $this->info("Imported: {$unionCouncilName}");
        }

        fclose($handle);

        $this->info('Import completed.');

        return Command::SUCCESS;
    }
}