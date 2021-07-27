<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name','name_ar', 'email', 'brand_name', 'brand_name_ar','cr'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
