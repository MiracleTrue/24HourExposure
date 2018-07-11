<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExposureCategory extends Model
{
    protected $fillable = [
        'name', 'description', 'item_count', 'sort'
    ];

    public function exposures()
    {
        return $this->hasMany(Exposure::class);
    }

}
