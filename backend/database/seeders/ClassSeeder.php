<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    public function run(): void
    {
        $school = \App\Models\School::first();
        if (!$school) return;

        $classes = [
            ['name' => 'Grade 9A', 'grade_level' => 9, 'section' => 'A', 'capacity' => 40],
            ['name' => 'Grade 9B', 'grade_level' => 9, 'section' => 'B', 'capacity' => 40],
            ['name' => 'Grade 10A', 'grade_level' => 10, 'section' => 'A', 'capacity' => 40],
            ['name' => 'Grade 10B', 'grade_level' => 10, 'section' => 'B', 'capacity' => 40],
        ];

        foreach ($classes as $class) {
            ClassRoom::firstOrCreate(
                ['school_id' => $school->id, 'grade_level' => $class['grade_level'], 'section' => $class['section']],
                array_merge($class, ['school_id' => $school->id])
            );
        }

        $this->command->info('✅ 4 classes created!');
    }
}
