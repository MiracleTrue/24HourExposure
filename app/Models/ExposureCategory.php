<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExposureCategory extends Model
{
    protected $fillable = [
        'name', 'description', 'item_count', 'sort'
    ];

    //默认排序
    public function scopeDefaultSort($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function exposures()
    {
        return $this->hasMany(Exposure::class);
    }

}
