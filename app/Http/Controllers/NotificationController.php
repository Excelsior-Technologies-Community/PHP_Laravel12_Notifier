<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserNotification;
use App\Notifications\WelcomeNotification;
use App\Notifications\OrderShippedNotification;
use App\Notifications\InvoicePaidNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Response;

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

        $user->notify(
            new OrderShippedNotification($orderData)
        );

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
     *
     * NEW:
     * Search
     * Status filter
     * Type filter
     * Sorting
     * Pagination
     */
    public function getUserNotifications(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $search = $request->input('search');

        $status = $request->input('status', 'all');

        $type = $request->input('type', 'all');

        $sort = $request->input('sort', 'newest');

        $perPage = (int) $request->input('per_page', 10);

        $allowedPerPage = [5, 10, 15, 25, 50];

        if (! in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }

        $query = $user->notifications();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($search) {
            $query->where(function ($q) use ($search) {

                $q->where('data->title', 'like', "%{$search}%")
                    ->orWhere('data->message', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Read / Unread Filter
        |--------------------------------------------------------------------------
        */

        if ($status === 'read') {
            $query->whereNotNull('read_at');
        }

        if ($status === 'unread') {
            $query->whereNull('read_at');
        }

        /*
        |--------------------------------------------------------------------------
        | Notification Type Filter
        |--------------------------------------------------------------------------
        */

        if ($type !== 'all') {

            $query->where(function ($q) use ($type) {

                $q->where('type', 'like', "%{$type}%")
                    ->orWhere('data->type', $type);
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */

        switch ($sort) {

            case 'oldest':
                $query->oldest();
                break;

            case 'title_asc':
                $query->orderByRaw(
                    "JSON_UNQUOTE(JSON_EXTRACT(data, '$.title')) ASC"
                );
                break;

            case 'title_desc':
                $query->orderByRaw(
                    "JSON_UNQUOTE(JSON_EXTRACT(data, '$.title')) DESC"
                );
                break;

            case 'newest':
            default:
                $query->latest();
                break;
        }

        $notifications = $query
            ->paginate($perPage)
            ->withQueryString();

        return response()->json([
            'user' => $user->name,
            'filters' => [
                'search' => $search,
                'status' => $status,
                'type' => $type,
                'sort' => $sort,
                'per_page' => $perPage,
            ],
            'notifications' => $notifications,
        ]);
    }

    /**
     * Get notification details.
     */
    public function show($userId, $notificationId)
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

        return response()->json([
            'notification' => $notification,
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
            'notification' => $notification->fresh(),
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
            'unread_count' => $user
                ->unreadNotifications()
                ->count(),
        ]);
    }

    /**
     * Soft delete notification.
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
            'message' => 'Notification moved to trash!',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | TRASH
    |--------------------------------------------------------------------------
    */

    /**
     * Get deleted notifications.
     */
    public function trash(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $notifications = $user->notifications()
            ->onlyTrashed()
            ->latest('deleted_at')
            ->paginate(10);

        return response()->json([
            'user' => $user->name,
            'notifications' => $notifications,
        ]);
    }

    /**
     * Restore notification.
     */
    public function restoreNotification(
        $userId,
        $notificationId
    ) {
        $user = User::findOrFail($userId);

        $notification = $user->notifications()
            ->onlyTrashed()
            ->where('id', $notificationId)
            ->first();

        if (! $notification) {
            return response()->json([
                'message' => 'Deleted notification not found!',
            ], 404);
        }

        $notification->restore();

        return response()->json([
            'message' => 'Notification restored successfully!',
        ]);
    }

    /**
     * Permanently delete notification.
     */
    public function forceDeleteNotification(
        $userId,
        $notificationId
    ) {
        $user = User::findOrFail($userId);

        $notification = $user->notifications()
            ->onlyTrashed()
            ->where('id', $notificationId)
            ->first();

        if (! $notification) {
            return response()->json([
                'message' => 'Deleted notification not found!',
            ], 404);
        }

        $notification->forceDelete();

        return response()->json([
            'message' => 'Notification permanently deleted!',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | ADVANCED ANALYTICS
    |--------------------------------------------------------------------------
    */

    public function analytics()
    {
        $total = UserNotification::count();

        $unread = UserNotification::whereNull('read_at')
            ->count();

        $read = UserNotification::whereNotNull('read_at')
            ->count();

        $today = UserNotification::whereDate(
            'created_at',
            today()
        )->count();

        $thisWeek = UserNotification::whereBetween(
            'created_at',
            [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ]
        )->count();

        $thisMonth = UserNotification::whereBetween(
            'created_at',
            [
                now()->startOfMonth(),
                now()->endOfMonth(),
            ]
        )->count();

        $readRate = $total > 0
            ? round(($read / $total) * 100, 2)
            : 0;

        $unreadRate = $total > 0
            ? round(($unread / $total) * 100, 2)
            : 0;

        $byType = UserNotification::query()
            ->selectRaw(
                "JSON_UNQUOTE(JSON_EXTRACT(data, '$.type')) as notification_type,
                 COUNT(*) as total"
            )
            ->groupBy('notification_type')
            ->orderByDesc('total')
            ->get();

        return response()->json([
            'total_notifications' => $total,
            'unread_notifications' => $unread,
            'read_notifications' => $read,

            'today_notifications' => $today,

            'this_week_notifications' => $thisWeek,

            'this_month_notifications' => $thisMonth,

            'read_rate' => $readRate,

            'unread_rate' => $unreadRate,

            'by_type' => $byType,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | CSV EXPORT
    |--------------------------------------------------------------------------
    */

    public function exportCsv(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $search = $request->input('search');

        $status = $request->input('status', 'all');

        $type = $request->input('type', 'all');

        $query = $user->notifications();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($search) {

            $query->where(function ($q) use ($search) {

                $q->where('data->title', 'like', "%{$search}%")
                    ->orWhere('data->message', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        */

        if ($status === 'read') {
            $query->whereNotNull('read_at');
        }

        if ($status === 'unread') {
            $query->whereNull('read_at');
        }

        /*
        |--------------------------------------------------------------------------
        | Type
        |--------------------------------------------------------------------------
        */

        if ($type !== 'all') {

            $query->where(function ($q) use ($type) {

                $q->where('type', 'like', "%{$type}%")
                    ->orWhere('data->type', $type);
            });
        }

        $notifications = $query
            ->latest()
            ->get();

        $filename = 'notifications-' . now()->format('Y-m-d-H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($notifications) {

            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'ID',
                'Title',
                'Message',
                'Type',
                'Status',
                'Created At',
            ]);

            foreach ($notifications as $notification) {

                $data = is_array($notification->data)
                    ? $notification->data
                    : json_decode(
                        $notification->data,
                        true
                    );

                fputcsv($file, [

                    $notification->id,

                    $data['title'] ?? 'Notification',

                    $data['message'] ?? '',

                    $data['type'] ?? $notification->type,

                    $notification->read_at
                        ? 'Read'
                        : 'Unread',

                    $notification->created_at,

                ]);
            }

            fclose($file);
        };

        return Response::stream(
            $callback,
            200,
            $headers
        );
    }
}
