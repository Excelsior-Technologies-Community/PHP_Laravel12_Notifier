<?php

namespace Database\Seeders;

use App\Models\User;
use App\Notifications\WelcomeNotification;
use App\Notifications\OrderShippedNotification;
use App\Notifications\CustomTemplateNotification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $userData = [
            [
                'name'     => 'Rahul Sharma',
                'email'    => 'rahul@example.com',
                'password' => Hash::make('password123'),
                'role'     => 'customer',
                'status'   => 'vip',
            ],
            [
                'name'     => 'Priya Patel',
                'email'    => 'priya@example.com',
                'password' => Hash::make('password123'),
                'role'     => 'customer',
                'status'   => 'active',
            ],
            [
                'name'     => 'Amit Verma',
                'email'    => 'amit@example.com',
                'password' => Hash::make('password123'),
                'role'     => 'vendor',
                'status'   => 'active',
            ],
            [
                'name'     => 'Neha Joshi',
                'email'    => 'neha@example.com',
                'password' => Hash::make('password123'),
                'role'     => 'admin',
                'status'   => 'active',
            ],
            [
                'name'     => 'Kiran Mehta',
                'email'    => 'kiran@example.com',
                'password' => Hash::make('password123'),
                'role'     => 'user',
                'status'   => 'inactive',
            ],
        ];

        foreach ($userData as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                $data
            );

            // Create notification preferences
            $user->getOrCreateNotificationPreference();

            // Clear old notifications if any to keep clean
            $user->notifications()->forceDelete();

            // 1. Welcome Notification
            $user->notify(new WelcomeNotification());

            // 2. Order Shipped Notification
            $user->notify(new OrderShippedNotification([
                'id'              => 'ORD-' . random_int(1000, 9999),
                'tracking_number' => 'TRK-' . strtoupper(uniqid()),
                'status'          => 'shipped',
            ]));

            // 3. Custom Announcement Notification (with priorities and variables)
            $user->notify(new CustomTemplateNotification([
                'raw_title'   => 'Special Announcement for {user_name}!',
                'raw_message' => 'Dear {user_name}, welcome to our platform! As a valued {user_role} member ({user_status}), you have special benefits on order {order_id}.',
                'priority'    => $user->status === 'vip' ? 'critical' : ($user->role === 'vendor' ? 'warning' : 'success'),
                'action_text' => 'Claim Privilege',
                'action_url'  => '/dashboard/privileges',
                'send_email'  => false,
                'metadata'    => [
                    'order_id' => 'ORD-' . random_int(5000, 9999),
                    'amount'   => '₹4,999',
                ],
            ]));

            // Mark one notification as read so test data has both read and unread
            $firstNotification = $user->notifications()->first();
            if ($firstNotification) {
                $firstNotification->markAsRead();
            }
        }
    }
}
