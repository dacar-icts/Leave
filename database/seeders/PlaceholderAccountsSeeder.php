<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PlaceholderAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create placeholder accounts for HR and Admin dashboards
        $placeholderUsers = [
            [
                'id' => 202506,
                'name' => 'HR Dashboard User',
                'email' => 'hr@placeholder.com',
                'password' => 'password',
                'role' => 'hr',
                'position' => 'HR Officer',
                'offices' => 'Human Resources',
            ],
            [
                'id' => 190620,
                'name' => 'Admin Dashboard User',
                'email' => 'admin@placeholder.com',
                'password' => 'password',
                'role' => 'admin',
                'position' => 'System Administrator',
                'offices' => 'Administration',
            ],
        ];

        foreach ($placeholderUsers as $userData) {
            // Check if user already exists
            $existingUser = User::find($userData['id']);
            
            if ($existingUser) {
                // Update existing user
                $existingUser->update([
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => $userData['password'],
                    'role' => $userData['role'],
                    'position' => $userData['position'],
                    'offices' => $userData['offices'],
                ]);
                $this->command->info("Updated placeholder user with ID {$userData['id']}: {$userData['name']}");
            } else {
                // Create new user
                User::create($userData);
                $this->command->info("Created placeholder user with ID {$userData['id']}: {$userData['name']}");
            }
        }

        $this->command->info('Placeholder accounts created successfully!');
        $this->command->info('You can now login with:');
        $this->command->info('- hr@placeholder.com (HR Dashboard - ID: 202506)');
        $this->command->info('- admin@placeholder.com (Admin Dashboard - ID: 190620)');
        $this->command->info('Password for both: password');
    }
}
