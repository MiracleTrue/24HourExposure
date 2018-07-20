<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exposure extends Model
{

    protected $fillable = [
        'location_id', 'category_id', 'name', 'title', 'content', 'gift_amount', 'comment_count'
    ];

    protected $appends = ['gifts'];

    //默认排序
    public function scopeDefaultSort($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function category()
    {
        return $this->belongsTo(ExposureCategory::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(ExposureComment::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getGiftsAttribute()
    {
        $all_gifts = Gift::getAllCached();
        $paid_orders = $this->orders->whereNotIn('paid_at', [null])->pluck('id');

        $all_gifts->transform(function ($item) use ($paid_orders) {
            $item->sum = $this->order_items->whereIn('order_id', $paid_orders)->where('gift_id', $item->id)->sum('number');
            return $item;
        });

        return $all_gifts;
    }

    public function order_items()
    {
        return $this->hasManyThrough(OrderItem::class, Order::class);
    }
}
