<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $school = \App\Models\School::first();
        if (!$school) return;

        $studentUser = User::where('email', 'student@sunrise.et')->first();

        Student::firstOrCreate(
            ['school_id' => $school->id, 'student_id' => 'STU-2026-0001'],
            [
                'user_id' => $studentUser?->id,
                'first_name' => 'Sara',
                'last_name' => 'Kebede',
                'date_of_birth' => '2010-05-15',
                'gender' => 'female',
                'address' => 'Addis Ababa',
                'guardian_name' => 'Abebe Kebede',
                'guardian_phone' => '+251911234567',
                'grade_level' => 9,
                'section' => 'A',
                'enrollment_date' => '2026-09-01',
                'status' => 'active',
            ]
        );

        $this->command->info('✅ 1 student created!');
    }
}
