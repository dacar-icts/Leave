<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 3 test users with IDs 1, 2, 3 and password "password"
        $testUsers = [
            [
                'id' => 1,
                'name' => 'Test User 1',
                'email' => 'test1@example.com',
                'password' => 'password',
                'role' => 'admin',
                'position' => 'System Administrator',
                'offices' => 'IT Department',
            ],
            [
                'id' => 2,
                'name' => 'Test User 2',
                'email' => 'test2@example.com',
                'password' => 'password',
                'role' => 'hr',
                'position' => 'HR Manager',
                'offices' => 'Human Resources',
            ],
            [
                'id' => 3,
                'name' => 'Test User 3',
                'email' => 'test3@example.com',
                'password' => 'password',
                'role' => 'employee',
                'position' => 'Software Developer',
                'offices' => 'IT Department',
            ],
        ];

        foreach ($testUsers as $userData) {
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
                $this->command->info("Updated user with ID {$userData['id']}: {$userData['name']}");
            } else {
                // Create new user
                User::create($userData);
                $this->command->info("Created user with ID {$userData['id']}: {$userData['name']}");
            }
        }

        $this->command->info('Test users created successfully!');
        $this->command->info('You can now login with:');
        $this->command->info('- test1@example.com (Admin)');
        $this->command->info('- test2@example.com (HR)');
        $this->command->info('- test3@example.com (Employee)');
        $this->command->info('Password for all: password');
    }
}
