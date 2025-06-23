<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use NotificationChannels\WebPush\HasPushSubscriptions;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\PasswordResetNotification;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes, HasPushSubscriptions, HasApiTokens;

    protected $fillable = ['email', 'password', 'role', 'is_active', 'email_verified_at'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean'
    ];

    /**
     * Get the client associated with the user.
     */
    public function client(): HasOne
    {
        return $this->hasOne(Client::class);
    }

    /**
     * Get the inspector associated with the user.
     */
    public function inspector(): HasOne
    {
        return $this->hasOne(Inspector::class);
    }

    /**
     * Get the marshal associated with the user.
     */
    public function marshall(): HasOne
    {
        return $this->hasOne(Marshall::class);
    }

    /**
     * Check if the user's email is verified.
     */
    public function isEmailVerified(): bool
    {
        return !is_null($this->email_verified_at);
    }

    /**
     * Check if the user is a marshall.
     */
    public function isMarshall(): bool
    {
        return $this->role === 'Marshall';
    }

    public function getFullName(): string
    {
        if ($this->role === 'Client' && $this->client) {
            return $this->client->getFullName();
        }

        if ($this->role === 'Inspector' && $this->inspector) {
            return $this->inspector->getFullName();
        }

        if ($this->role === 'Marshall' && $this->marshall) {
            return $this->marshall->getFullName();
        }

        return 'Administrator';
    }

    public function getProfile(): ?object
    {
        if ($this->role === 'Client' && $this->client) {
            return $this->client;
        }

        if ($this->role === 'Inspector' && $this->inspector) {
            return $this->inspector;
        }

        if ($this->role === 'Marshall' && $this->marshall) {
            return $this->marshall;
        }

        return null;
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordResetNotification($token));
    }
}
