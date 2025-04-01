<?php

namespace App\Models\Payment;

use App\Models\Advertiser;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $table = 'wallets';
    protected $guarded = [];

    public function advertiser()
    {
        return $this->belongsTo(Advertiser::class, 'user_id', 'id');
    }
}
