<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            ClassSeeder::class,
            SubjectSeeder::class,
            RoomSeeder::class,
            TeacherSeeder::class,
            StudentSeeder::class,
            TeacherAssignmentSeeder::class,
            ScheduleSeeder::class,
            NotificationSeeder::class,
        ]);
    }
}