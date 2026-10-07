<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            SchoolSeeder::class,
            UserSeeder::class,
            SubjectSeeder::class,
            ClassSeeder::class,
            TeacherSeeder::class,
            StudentSeeder::class,
        ]);
    }
}
