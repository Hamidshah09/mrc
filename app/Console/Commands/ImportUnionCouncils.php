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

            $secretaryName = trim($row[0]);
            $unionCouncilName = trim($row[1]);

            if (!$secretaryName || !$unionCouncilName) {
                continue;
            }

            // Create secretary user if not exists
            $user = User::firstOrCreate(
                ['name' => $secretaryName],
                [
                    'email' => strtolower(str_replace(' ', '.', $secretaryName)) . '@cfc.com',
                    'password' => Hash::make('12345678'),
                    'role_id' => 6,
                    'mobile' => '000000000' . $mobile++, // Increment mobile number for each secretary
                ]
            );

            // Create or update union council
            UnionCouncil::updateOrCreate(
                ['name' => $unionCouncilName],
                ['user_id' => $user->id]
            );

            $this->info("Imported: {$unionCouncilName}");
        }

        fclose($handle);

        $this->info('Import completed.');

        return Command::SUCCESS;
    }
}