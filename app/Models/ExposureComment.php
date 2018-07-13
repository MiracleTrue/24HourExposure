<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExposureComment extends Model
{
    protected $fillable = [
        'exposure_id', 'content'
    ];

    //默认排序
    public function scopeDefaultSort($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function exposure()
    {
        return $this->belongsTo(Exposure::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
