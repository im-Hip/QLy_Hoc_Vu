<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\User;

class NotificationSeeder extends Seeder
{
    public function run()
    {
        $admin = User::where('role', 'admin')->first();
        $student = User::where('role', 'student')->first();

        Notification::create([
            'title' => 'Sample Notification 1',
            'content' => 'This is a sample notification',
            'type' => 'event',
            'sender_id' => $admin->id,
            'recipient_type' => 'user',
            'recipient_id' => $student->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Notification::create([
            'title' => 'Sample Notification 2',
            'content' => 'This is another sample notification',
            'type' => 'assignment',
            'sender_id' => $admin->id,
            'recipient_type' => 'user',
            'recipient_id' => $student->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}