<?php

namespace App\Models\Inc;

use Illuminate\Database\Eloquent\Model;

class CustomPages extends Model
{
    protected $table = 'custompages';
    protected $guarded = [];

    public function childs()
    {
        return $this->hasMany(CustomPages::class, 'parent_id', 'id');
    }

    public function parent(){
        return $this->belongsTo(CustomPages::class, 'parent_id', 'id');
    }
}
