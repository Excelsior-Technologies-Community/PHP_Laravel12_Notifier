<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;

// User routes
Route::prefix('users')->group(function () {
    Route::post('/', [UserController::class, 'createTestUser']);
    Route::get('/', [UserController::class, 'listUsers']);
});

// Notification routes
Route::prefix('notifications')->group(function () {
    // Send notifications
    Route::post('/welcome/{userId}', [NotificationController::class, 'sendWelcomeNotification']);
    Route::post('/order-shipped/{userId}', [NotificationController::class, 'sendOrderShippedNotification']);
    Route::post('/broadcast', [NotificationController::class, 'broadcastNotification']);
    
    // Get and manage notifications
    Route::get('/user/{userId}', [NotificationController::class, 'getUserNotifications']);
    Route::post('/mark-as-read/{userId}/{notificationId}', [NotificationController::class, 'markAsRead']);
    Route::post('/mark-all-read/{userId}', [NotificationController::class, 'markAllAsRead']);
    Route::delete('/delete/{userId}/{notificationId}', [NotificationController::class, 'deleteNotification']);
});