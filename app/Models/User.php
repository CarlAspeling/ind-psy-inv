<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Panel;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'email_verified',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'email_verified' => 'boolean',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is an admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is a regular user
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Get user's questionnaire attempts
     */
    public function questionnaireAttempts(): HasMany
    {
        return $this->hasMany(QuestionnaireAttempt::class);
    }

    /**
     * Automatically sync email_verified_at when email_verified changes
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($user) {
            // If email_verified is being set to true and email_verified_at is null, set it to now
            if ($user->email_verified && is_null($user->email_verified_at)) {
                $user->email_verified_at = now();
            }

            // If email_verified is being set to false, clear email_verified_at
            if (!$user->email_verified) {
                $user->email_verified_at = null;
            }
        });
    }

//    public function questionnaires(): BelongsToMany
//    {
//        return $this->belongsToMany(Questionnaire::class);
//    }
}
