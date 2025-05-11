<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

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
            'password' => 'hashed',
        ];
    
    // Mendapatkan identifier untuk JWT
    public function getJWTIdentifier()
    {
        return $this->getKey(); // Menggunakan primary key model sebagai identifier
    }

    // Mendapatkan klaim kustom untuk JWT (biasanya kosong)
    public function getJWTCustomClaims()
    {
        return [];
    }
}
