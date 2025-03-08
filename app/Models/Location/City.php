<?php

namespace App\Models\Location;

use App\Models\Location\Block;
use App\Models\Location\State;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    protected $fillable = ['state_id', 'name','slug'];
    public function state()
    {
        return $this->belongsTo(State::class);
    }
    public function blocks()
    {
        return $this->hasMany(Block::class);
    }
}
