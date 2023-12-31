<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Notification;
class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Notification::create([
        //     'notification_from' => 2,
        //     'notification_to' => 3,
        //     'notification_type' => 'booking_request',
        //     'notification' => 'You have new Booking request from Pir Mohsin Shah',
        // ]);

        // Notification::create([
        //     'notification_from' => 3,
        //     'notification_to' => 2,
        //     'notification_type' => 'booking_accepted',
        //     'notification' => 'Your booking request has been Accepted',
        // ]);
    }
}
