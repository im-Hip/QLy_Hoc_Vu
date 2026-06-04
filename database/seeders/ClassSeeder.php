<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classes;

class ClassSeeder extends Seeder
{
    public function run()
    {
        Classes::create([
            'name' => '10A1',
            'grade' => '10',
            'number_of_students' => '40',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Classes::create([
            'name' => '11A1',
            'grade' => '11',
            'number_of_students' => '38',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Classes::create([
            'name' => '12A1',
            'grade' => '12',
            'number_of_students' => '35',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}