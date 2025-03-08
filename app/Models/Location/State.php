<?php

namespace App\Models\Location;

use App\Models\Location\City;
use App\Models\Location\Block;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
     public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function blocks()
    {
        return $this->hasMany(Block::class);
    }
}
