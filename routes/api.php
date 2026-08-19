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

    // Send notifications
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

    // User notifications
    Route::get('/user/{userId}', [
        NotificationController::class,
        'getUserNotifications',
    ]);

    // Notification management
    Route::post('/mark-as-read/{userId}/{notificationId}', [
        NotificationController::class,
        'markAsRead',
    ]);

    Route::post('/mark-all-read/{userId}', [
        NotificationController::class,
        'markAllAsRead',
    ]);

    Route::delete('/delete/{userId}/{notificationId}', [
        NotificationController::class,
        'deleteNotification',
    ]);

    // Notification preferences
    Route::get('/preferences/{userId}', [
        NotificationPreferenceController::class,
        'show',
    ]);

    Route::put('/preferences/{userId}', [
        NotificationPreferenceController::class,
        'update',
    ]);

    // Notification analytics
    Route::get('/analytics', [
        NotificationController::class,
        'analytics',
    ]);
});