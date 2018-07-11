<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exposure extends Model
{

    protected $fillable = [
        'category_id', 'name', 'title', 'content'
    ];

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
}
