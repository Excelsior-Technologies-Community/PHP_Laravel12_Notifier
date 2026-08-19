<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a test user.
     */
    public function createTestUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Create default notification preferences.
        $user->notificationPreference()->create([
            'welcome_enabled' => true,
            'order_shipped_enabled' => true,
            'invoice_paid_enabled' => true,
        ]);

        return response()->json([
            'message' => 'User created successfully!',
            'user' => $user->load('notificationPreference'),
        ], 201);
    }

    /**
     * List all users.
     */
    public function listUsers()
    {
        $users = User::with('notificationPreference')
            ->latest()
            ->get();

        return response()->json([
            'users' => $users,
            'count' => $users->count(),
        ]);
    }
}