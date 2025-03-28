<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject; // Tambahkan ini

class UserModel extends Authenticatable implements JWTSubject 
{
    use HasFactory, Notifiable, HasRoles;

    protected $table = 'tbl_user';
    protected $primaryKey = 'user_id';
    
    protected $guard_name = 'api'; // 🔹 Tambahkan ini

    protected $fillable = [
        'user_nmlengkap',
        'user_nama',
        'user_email',
        'user_password',
        'user_foto',
        'role_id'
    ];

    protected $hidden = [
        'user_password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'user_password' => 'hashed',
        ];
    }

    public function getAuthIdentifierName()
    {
        return 'user_id';
    }

    public function getAuthPassword()
    {
        return $this->user_password;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    // 🔹 Implementasikan JWTSubject
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    public function getMorphClass()
    {
        return 'App\Models\UserModel'; // Samakan dengan yang ada di database
    }
}
