<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    public $table = 'admins';

    protected $guard = 'admin'; // Set the guard explicitly

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'status',
    ];

    protected $hidden = [
        'password',
    ];
}
