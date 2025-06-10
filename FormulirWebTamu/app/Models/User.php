<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Add the role field here
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Check if the user is a receptionist.
     *
     * @return bool
     */
    public function isReceptionist(): bool
    {
        return $this->role === 'receptionist';
    }

    /**
     * Check if the user is a secretary.
     *
     * @return bool
     */
    public function isSecretary(): bool
    {
        return $this->role === 'secretary';
    }

    /**
     * Check if the user is part of management.
     *
     * @return bool
     */
    public function isManagement(): bool
    {
        return str_starts_with($this->role, 'management-');
    }
}
