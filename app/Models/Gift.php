<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    protected $fillable = [
        'title', 'image', 'price', 'sort'
    ];

    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
