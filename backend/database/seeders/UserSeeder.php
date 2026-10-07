<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $school = \App\Models\School::first();

        $users = [
            ['name' => 'Super Admin', 'email' => 'super@ssms.et', 'role' => 'super_admin'],
            ['name' => 'School Admin', 'email' => 'admin@sunrise.et', 'role' => 'admin'],
            ['name' => 'Director', 'email' => 'director@sunrise.et', 'role' => 'director'],
            ['name' => 'Teacher User', 'email' => 'teacher@sunrise.et', 'role' => 'teacher'],
            ['name' => 'Student User', 'email' => 'student@sunrise.et', 'role' => 'student'],
            ['name' => 'Parent User', 'email' => 'parent@sunrise.et', 'role' => 'parent'],
            ['name' => 'Accountant', 'email' => 'accountant@sunrise.et', 'role' => 'accountant'],
            ['name' => 'Librarian', 'email' => 'librarian@sunrise.et', 'role' => 'librarian'],
        ];

        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make('password'),
                    'role' => $userData['role'],
                    'school_id' => $userData['role'] === 'super_admin' ? null : $school?->id,
                    'is_active' => true,
                ]
            );

            if ($user->role !== 'super_admin') {
                $user->assignRole($user->role);
            } else {
                $user->assignRole('super_admin');
            }
        }

        $this->command->info('✅ 8 users created (password: password)');
    }
}
