<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    protected $fillable = [
        'category_id', 'name', 'description', 'item_count', 'sort'
    ];

    //默认排序
    public function scopeDefaultSort($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }
}
