<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'name_ar',
        'email',
        'brand_name',
        'brand_name_ar',
        'cr', // this for file that user upload if he wants that
        'admin_sent' // this for check if this request sent to admin or not
    ];
}
