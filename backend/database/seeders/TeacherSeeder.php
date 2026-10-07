<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $school = \App\Models\School::first();
        if (!$school) return;

        $teacherUser = User::where('email', 'teacher@sunrise.et')->first();
        if (!$teacherUser) return;

        Teacher::firstOrCreate(
            ['school_id' => $school->id, 'user_id' => $teacherUser->id],
            [
                'employee_id' => 'TCH-2026-001',
                'qualification' => 'MSc Mathematics',
                'specialization' => 'Mathematics',
                'hire_date' => '2020-09-01',
                'salary' => 15000.00,
                'status' => 'active',
            ]
        );

        $this->command->info('✅ 1 teacher created!');
    }
}
