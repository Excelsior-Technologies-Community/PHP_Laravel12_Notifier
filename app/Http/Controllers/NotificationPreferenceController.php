<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class NotificationPreferenceController extends Controller
{
    /**
     * Get notification preferences for a user.
     */
    public function show($userId)
    {
        $user = User::findOrFail($userId);

        $preferences = $user->getOrCreateNotificationPreference();

        return response()->json([
            'user' => $user->name,
            'preferences' => $preferences,
        ]);
    }

    /**
     * Update notification preferences.
     */
    public function update(Request $request, $userId)
    {
        $validated = $request->validate([
            'welcome_enabled' => 'required|boolean',
            'order_shipped_enabled' => 'required|boolean',
            'invoice_paid_enabled' => 'required|boolean',
        ]);

        $user = User::findOrFail($userId);

        $preferences = $user->getOrCreateNotificationPreference();

        $preferences->update([
            'welcome_enabled' => $validated['welcome_enabled'],
            'order_shipped_enabled' => $validated['order_shipped_enabled'],
            'invoice_paid_enabled' => $validated['invoice_paid_enabled'],
        ]);

        return response()->json([
            'message' => 'Notification preferences updated successfully!',
            'preferences' => $preferences->fresh(),
        ]);
    }
}