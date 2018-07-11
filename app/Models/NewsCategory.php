<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    protected $fillable = [
        'name', 'description', 'item_count', 'sort'
    ];

    public function news()
    {
        return $this->hasMany(News::class);
    }
}
