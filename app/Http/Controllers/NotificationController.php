<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\WelcomeNotification;
use App\Notifications\OrderShippedNotification;
use App\Notifications\InvoicePaidNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    // Send welcome notification
    public function sendWelcomeNotification($userId)
    {
        $user = User::findOrFail($userId);
        
        // Send notification
        $user->notify(new WelcomeNotification());
        
        return response()->json([
            'message' => 'Welcome notification sent successfully!',
            'user' => $user->name,
        ]);
    }
    
    // Send order shipped notification
    public function sendOrderShippedNotification($userId)
    {
        $user = User::findOrFail($userId);
        
        $orderData = [
            'id' => 'ORD-' . rand(1000, 9999),
            'tracking_number' => 'TRK-' . strtoupper(uniqid()),
            'status' => 'shipped',
        ];
        
        $user->notify(new OrderShippedNotification($orderData));
        
        return response()->json([
            'message' => 'Order shipped notification sent!',
            'order' => $orderData,
        ]);
    }
    
    // Send notification to multiple users
    public function broadcastNotification()
    {
        $users = User::all();
        
        $notificationData = [
            'title' => 'System Update',
            'message' => 'Our system will undergo maintenance on Friday at 2 AM.',
            'type' => 'system',
            'icon' => 'bell',
        ];
        
        Notification::send($users, new InvoicePaidNotification($notificationData));
        
        return response()->json([
            'message' => 'Broadcast notification sent to all users!',
            'users_count' => $users->count(),
        ]);
    }
    
    // Get user notifications
    public function getUserNotifications($userId)
    {
        $user = User::findOrFail($userId);
        $notifications = $user->notifications()->paginate(10);
        
        return response()->json([
            'user' => $user->name,
            'notifications' => $notifications,
        ]);
    }
    
    // Mark notification as read
    public function markAsRead($userId, $notificationId)
    {
        $user = User::findOrFail($userId);
        $notification = $user->notifications()->where('id', $notificationId)->first();
        
        if ($notification) {
            $notification->markAsRead();
            
            return response()->json([
                'message' => 'Notification marked as read!',
                'notification' => $notification,
            ]);
        }
        
        return response()->json([
            'message' => 'Notification not found!',
        ], 404);
    }
    
    // Mark all notifications as read
    public function markAllAsRead($userId)
    {
        $user = User::findOrFail($userId);
        $user->unreadNotifications->markAsRead();
        
        return response()->json([
            'message' => 'All notifications marked as read!',
            'unread_count' => $user->unreadNotifications()->count(),
        ]);
    }
    
    // Delete notification
    public function deleteNotification($userId, $notificationId)
    {
        $user = User::findOrFail($userId);
        $notification = $user->notifications()->where('id', $notificationId)->first();
        
        if ($notification) {
            $notification->delete();
            
            return response()->json([
                'message' => 'Notification deleted!',
            ]);
        }
        
        return response()->json([
            'message' => 'Notification not found!',
        ], 404);
    }
}