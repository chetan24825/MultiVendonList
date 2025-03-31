<?php

namespace App\Models\Inc;

use App\Models\Advertiser;
use Illuminate\Database\Eloquent\Model;

class MessageLead extends Model
{
    protected $table = 'message_leads';
    protected $guarded = [];

    public function advertiser()
    {
        return $this->belongsTo(Advertiser::class, 'advertiser_id', 'id');
    }
}
