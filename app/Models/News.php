<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'category_id', 'title', 'content'
    ];

    public function category()
    {
        return $this->belongsTo(NewsCategory::class);
    }
}
