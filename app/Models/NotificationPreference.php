<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationPreference extends Model
{
    protected $fillable = [
        'user_id',
        'welcome_enabled',
        'order_shipped_enabled',
        'invoice_paid_enabled',
    ];

    protected $casts = [
        'welcome_enabled' => 'boolean',
        'order_shipped_enabled' => 'boolean',
        'invoice_paid_enabled' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}