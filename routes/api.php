<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationPreferenceController;

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/

Route::prefix('users')->group(function () {

    Route::post('/', [
        UserController::class,
        'createTestUser',
    ]);

    Route::get('/', [
        UserController::class,
        'listUsers',
    ]);
});


/*
|--------------------------------------------------------------------------
| Notification Routes
|--------------------------------------------------------------------------
*/

Route::prefix('notifications')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Send Notifications
    |--------------------------------------------------------------------------
    */

    Route::post('/welcome/{userId}', [
        NotificationController::class,
        'sendWelcomeNotification',
    ]);

    Route::post('/order-shipped/{userId}', [
        NotificationController::class,
        'sendOrderShippedNotification',
    ]);

    Route::post('/broadcast', [
        NotificationController::class,
        'broadcastNotification',
    ]);


    /*
    |--------------------------------------------------------------------------
    | Notification List
    |--------------------------------------------------------------------------
    */

    Route::get('/user/{userId}', [
        NotificationController::class,
        'getUserNotifications',
    ]);


    /*
    |--------------------------------------------------------------------------
    | Notification Details
    |--------------------------------------------------------------------------
    */

    Route::get('/user/{userId}/{notificationId}', [
        NotificationController::class,
        'show',
    ]);


    /*
    |--------------------------------------------------------------------------
    | Mark As Read
    |--------------------------------------------------------------------------
    */

    Route::post('/mark-as-read/{userId}/{notificationId}', [
        NotificationController::class,
        'markAsRead',
    ]);

    Route::post('/mark-all-read/{userId}', [
        NotificationController::class,
        'markAllAsRead',
    ]);


    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    Route::delete('/delete/{userId}/{notificationId}', [
        NotificationController::class,
        'deleteNotification',
    ]);


    /*
    |--------------------------------------------------------------------------
    | Trash
    |--------------------------------------------------------------------------
    */

    Route::get('/trash/{userId}', [
        NotificationController::class,
        'trash',
    ])->name('notifications.trash');

    Route::post('/restore/{userId}/{notificationId}', [
        NotificationController::class,
        'restoreNotification',
    ])->name('notifications.restore');

    Route::delete('/force-delete/{userId}/{notificationId}', [
        NotificationController::class,
        'forceDeleteNotification',
    ])->name('notifications.force-delete');


    /*
    |--------------------------------------------------------------------------
    | Search / Filter / Sort
    |--------------------------------------------------------------------------
    |
    | These are handled by /user/{userId}.
    |
    | Example:
    |
    | /api/notifications/user/1?search=order
    | /api/notifications/user/1?status=unread
    | /api/notifications/user/1?type=order
    | /api/notifications/user/1?sort=oldest
    |
    */


    /*
    |--------------------------------------------------------------------------
    | Export CSV
    |--------------------------------------------------------------------------
    */

    Route::get('/export/{userId}', [
        NotificationController::class,
        'exportCsv',
    ])->name('notifications.export');


    /*
    |--------------------------------------------------------------------------
    | Preferences
    |--------------------------------------------------------------------------
    */

    Route::get('/preferences/{userId}', [
        NotificationPreferenceController::class,
        'show',
    ]);

    Route::put('/preferences/{userId}', [
        NotificationPreferenceController::class,
        'update',
    ]);


    /*
    |--------------------------------------------------------------------------
    | Analytics
    |--------------------------------------------------------------------------
    */

    Route::get('/analytics', [
        NotificationController::class,
        'analytics',
    ]);
});
