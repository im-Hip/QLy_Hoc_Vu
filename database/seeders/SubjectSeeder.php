<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run()
    {
        Subject::create([
            'name' => 'Math',
            'subject_id' => 'MATH',
            'number_of_periods' => 4,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Subject::create([
            'name' => 'Science',
            'subject_id' => 'SCI',
            'number_of_periods' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Subject::create([
            'name' => 'English',
            'subject_id' => 'ENG',
            'number_of_periods' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}