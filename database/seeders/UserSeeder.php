<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'hadanghiep@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'admin',
        ]);


        User::create([
            'name' => 'Teacher A',
            'email' => 'teacher_a@example.com',
            'password' => Hash::make('123456'),
            'role' => 'teacher',
        ]);

        User::create([
            'name' => 'Student A',
            'email' => 'student_a@example.com',
            'password' => Hash::make('123456'),
            'role' => 'student',
        ]);

        User::create([
            'name' => 'Student B',
            'email' => 'student_b@example.com',
            'password' => Hash::make('123456'),
            'role' => 'student',
        ]);
        User::factory()->count(12)->teacher()->create();

        User::factory()->count(200)->student()->create();
    }
}
