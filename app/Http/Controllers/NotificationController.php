<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\WelcomeNotification;
use App\Notifications\OrderShippedNotification;
use App\Notifications\InvoicePaidNotification;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    /**
     * Send welcome notification.
     */
    public function sendWelcomeNotification($userId)
    {
        $user = User::findOrFail($userId);

        $preferences = $user->getOrCreateNotificationPreference();

        if (! $preferences->welcome_enabled) {
            return response()->json([
                'message' => 'Welcome notifications are disabled for this user.',
                'sent' => false,
            ], 422);
        }

        $user->notify(new WelcomeNotification());

        return response()->json([
            'message' => 'Welcome notification sent successfully!',
            'user' => $user->name,
            'sent' => true,
        ]);
    }

    /**
     * Send order shipped notification.
     */
    public function sendOrderShippedNotification($userId)
    {
        $user = User::findOrFail($userId);

        $preferences = $user->getOrCreateNotificationPreference();

        if (! $preferences->order_shipped_enabled) {
            return response()->json([
                'message' => 'Order shipped notifications are disabled for this user.',
                'sent' => false,
            ], 422);
        }

        $orderData = [
            'id' => 'ORD-' . random_int(1000, 9999),
            'tracking_number' => 'TRK-' . strtoupper(uniqid()),
            'status' => 'shipped',
        ];

        $user->notify(new OrderShippedNotification($orderData));

        return response()->json([
            'message' => 'Order shipped notification sent!',
            'order' => $orderData,
            'sent' => true,
        ]);
    }

    /**
     * Send notification to multiple users.
     */
    public function broadcastNotification()
    {
        $users = User::all();

        $notificationData = [
            'title' => 'System Update',
            'message' => 'Our system will undergo maintenance on Friday at 2 AM.',
            'type' => 'system',
            'icon' => 'bell',
        ];

        Notification::send(
            $users,
            new InvoicePaidNotification($notificationData)
        );

        return response()->json([
            'message' => 'Broadcast notification sent to all eligible users!',
            'users_count' => $users->count(),
        ]);
    }

    /**
     * Get user notifications.
     */
    public function getUserNotifications($userId)
    {
        $user = User::findOrFail($userId);

        $notifications = $user->notifications()
            ->latest()
            ->paginate(10);

        return response()->json([
            'user' => $user->name,
            'notifications' => $notifications,
        ]);
    }

    /**
     * Mark one notification as read.
     */
    public function markAsRead($userId, $notificationId)
    {
        $user = User::findOrFail($userId);

        $notification = $user->notifications()
            ->where('id', $notificationId)
            ->first();

        if (! $notification) {
            return response()->json([
                'message' => 'Notification not found!',
            ], 404);
        }

        $notification->markAsRead();

        return response()->json([
            'message' => 'Notification marked as read!',
            'notification' => $notification,
        ]);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead($userId)
    {
        $user = User::findOrFail($userId);

        $user->unreadNotifications->markAsRead();

        return response()->json([
            'message' => 'All notifications marked as read!',
            'unread_count' => $user->unreadNotifications()->count(),
        ]);
    }

    /**
     * Delete notification.
     */
    public function deleteNotification($userId, $notificationId)
    {
        $user = User::findOrFail($userId);

        $notification = $user->notifications()
            ->where('id', $notificationId)
            ->first();

        if (! $notification) {
            return response()->json([
                'message' => 'Notification not found!',
            ], 404);
        }

        $notification->delete();

        return response()->json([
            'message' => 'Notification deleted!',
        ]);
    }

    /**
     * Notification analytics.
     */
    public function analytics()
    {
        $total = DatabaseNotification::count();

        $unread = DatabaseNotification::whereNull('read_at')->count();

        $read = DatabaseNotification::whereNotNull('read_at')->count();

        $byType = DatabaseNotification::query()
            ->selectRaw('type, COUNT(*) as total')
            ->groupBy('type')
            ->orderByDesc('total')
            ->get();

        return response()->json([
            'total_notifications' => $total,
            'unread_notifications' => $unread,
            'read_notifications' => $read,
            'by_type' => $byType,
        ]);
    }
}