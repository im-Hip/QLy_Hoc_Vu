<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\User;
use App\Models\Classes;

class StudentSeeder extends Seeder
{
    public function run()
    {
        $studentUser = User::where('email', 'student_a@example.com')->first();
        $class = Classes::where('name', '10A1')->first();
        Student::create([
            'id' => $studentUser->id,
            'student_id' => 'HS001',
            'day_of_birth' => '2008-01-01',
            'gender' => 'male',
            'class_id' => $class->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $studentUser2 = User::where('email', 'student_b@example.com')->first();
        $class2 = Classes::where('name', '11A1')->first();
        Student::create([
            'id' => $studentUser2->id,
            'student_id' => 'HS002',
            'day_of_birth' => '2008-02-01',
            'gender' => 'female',
            'class_id' => $class2->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}