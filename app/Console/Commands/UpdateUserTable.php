<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;

class UpdateUserTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-user-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate users table with role_id based on existing role field';

    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            // Find the corresponding role record
            $role = Role::where('role', $user->role)->first();

            if ($role) {
                // Update the user's role_id
                $user->role_id = $role->id;
                $user->save();

                $this->info("✅ Updated user {$user->id} ({$user->name}) with role_id {$role->id}");
            } else {
                $this->warn("⚠️ No matching role found for user {$user->id} ({$user->name}) — role: {$user->role}");
            }
        }

        $this->info('🎉 User table successfully updated with role IDs.');
    }
}
