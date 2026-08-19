<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * User notification preferences.
     */
    public function notificationPreference(): HasOne
    {
        return $this->hasOne(NotificationPreference::class);
    }

    /**
     * Get existing preferences or create default preferences.
     */
    public function getOrCreateNotificationPreference(): NotificationPreference
    {
        return $this->notificationPreference()->firstOrCreate([
            'user_id' => $this->id,
        ]);
    }

    /**
     * Custom notifications relationship.
     *
     * This allows SoftDeletes to work with
     * notification records.
     */
    public function notifications(): MorphMany
    {
        return $this->morphMany(
            UserNotification::class,
            'notifiable'
        );
    }
}
