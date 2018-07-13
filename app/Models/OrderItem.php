<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [

        'number', 'item_price'

    ];

    protected $casts = [
        'snapshot' => 'json',
    ];

    public $timestamps = false;


    public function gift()
    {
        return $this->belongsTo(Gift::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
