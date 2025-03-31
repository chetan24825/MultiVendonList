<?php

namespace App\Models\Inc;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $table = 'leads';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
