<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'category_id', 'title', 'content'
    ];

    //默认排序
    public function scopeDefaultSort($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function category()
    {
        return $this->belongsTo(NewsCategory::class);
    }
}
