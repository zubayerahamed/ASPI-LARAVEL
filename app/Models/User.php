<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'activation_token',

        'status',
        'register_type',
        'latitude',
        'longitude',

        'is_system_admin',
        'is_business_admin',
        'is_driver',
        'is_customer',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'activation_token',
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
            'password' => 'hashed',
            'is_system_admin' => 'boolean',
            'is_business_admin' => 'boolean',
            'is_driver' => 'boolean',
            'is_customer' => 'boolean',
            'password_changed' => 'boolean',
        ];
    }

    /**
     * Check if user is active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    public function requiresPasswordChange()
    {
        return !$this->password_changed;
    }

    /**
     * The businesses that belong to the user.
     */
    public function businesses()
    {
        return $this->belongsToMany(Business::class, 'user_businesseses')->withPivot('is_active');
    }

    /**
     * The profiles that belong to the user.
     */
    public function profiles()
    {
        return $this->belongsToMany(Profile::class, 'user_profiles')->withPivot('business_id');
    }

}
