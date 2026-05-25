<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\User;
use App\Models\PoliceStation;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Maatwebsite\Excel\Facades\Excel;

class ImportUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import users from Excel file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = storage_path('app/users.xlsx');

        if (!file_exists($filePath)) {

            $this->error('users.xlsx file not found.');

            return;
        }

        $rows = Excel::toArray([], $filePath);

        $rows = $rows[0];

        unset($rows[0]);

        foreach ($rows as $row) {

            /*
            |------------------------------------------------------------------
            | Skip Empty Rows
            |------------------------------------------------------------------
            */
             if (empty($row[1])) {
                continue;
            }

            /*
            |------------------------------------------------------------------
            | Get Police Station
            |------------------------------------------------------------------
            */

            $policeStationId = null;

            if (!empty($row[3]) && $row[3] != '--') {

                $policeStation = PoliceStation::where('name', trim($row[3]))
                    ->first();

                if ($policeStation) {
                    $policeStationId = $policeStation->id;
                }
            }

            /*
            |------------------------------------------------------------------
            | Prevent Duplicate Emails
            |------------------------------------------------------------------
            */

            $existingUser = User::where('email', trim($row[4]))
                ->first();

            if ($existingUser) {

                $this->warn('Skipped existing email: ' . $row[4]);

                continue;
            }

            /*
            |------------------------------------------------------------------
            | Create User
            |------------------------------------------------------------------
            */

            User::create([

                'name' => trim($row[1]),

                'sub_division_id' => $row[2],

                'policestation_id' => $policeStationId,

                'email' => trim($row[4]),

                'mobile' => trim($row[5]),

                'role_id' => $row[6],

                'status' => 'Active',

                'password' => Hash::make('12345678'),

                'remember_token' => Str::random(10),
            ]);

            $this->info('Imported: ' . $row[1]);
        }

        $this->info('Users imported successfully.');
    }
}
