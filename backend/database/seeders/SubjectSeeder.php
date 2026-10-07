<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $school = \App\Models\School::first();
        if (!$school) return;

        $subjects = [
            ['name' => 'Mathematics', 'code' => 'MATH101', 'grade_level' => 9, 'credit_hours' => 4],
            ['name' => 'English', 'code' => 'ENG101', 'grade_level' => 9, 'credit_hours' => 4],
            ['name' => 'Physics', 'code' => 'PHY101', 'grade_level' => 9, 'credit_hours' => 3],
            ['name' => 'Chemistry', 'code' => 'CHEM101', 'grade_level' => 9, 'credit_hours' => 3],
            ['name' => 'Biology', 'code' => 'BIO101', 'grade_level' => 9, 'credit_hours' => 3],
            ['name' => 'History', 'code' => 'HIST101', 'grade_level' => 9, 'credit_hours' => 2],
            ['name' => 'Geography', 'code' => 'GEO101', 'grade_level' => 9, 'credit_hours' => 2],
            ['name' => 'Amharic', 'code' => 'AMH101', 'grade_level' => 9, 'credit_hours' => 3],
        ];

        foreach ($subjects as $subject) {
            Subject::firstOrCreate(
                ['school_id' => $school->id, 'code' => $subject['code']],
                array_merge($subject, ['school_id' => $school->id])
            );
        }

        $this->command->info('✅ 8 subjects created!');
    }
}
