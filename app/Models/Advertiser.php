<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Advertiser extends Authenticatable
{
    protected $table = 'advertisers';
    protected $guarded = [];
}
