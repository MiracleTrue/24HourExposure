<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exposure extends Model
{

    protected $fillable = [
        'category_id', 'name', 'title', 'content'
    ];

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

    public function order()
    {
        return $this->belongsTo(Order::class);

    }

    public function order_items()
    {
//
//        return $this->belongsToMany(Product::class, 'user_favorite_products')
//            ->withTimestamps()
//            ->orderBy('user_favorite_products.created_at', 'desc');

    }
}
