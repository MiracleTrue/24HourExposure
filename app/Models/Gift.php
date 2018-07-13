<?php

namespace App\Models;

use App\Observers\GiftObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Gift extends Model
{
    protected $fillable = [
        'title', 'image', 'price', 'sort'
    ];

    protected $appends = ['image_url'];

    public static $cache_key = '24HourExposure_gifts';
    protected static $cache_expire_in_minutes = 1440;//24小时

    /**
     * 模型的事件映射。
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => GiftObserver::class,
        'saved' => GiftObserver::class,
        'deleted' => GiftObserver::class,
    ];

    //默认排序
    public function scopeDefaultSort($query)
    {
        return $query->orderBy('created_at', 'desc');
    }


    public static function getAllCached()
    {
        // 尝试从缓存中取出 cache_key 对应的数据。如果能取到，便直接返回数据。
        // 否则运行匿名函数中的代码来取出 gifts 表中所有的数据，返回的同时做了缓存。
        return Cache::remember(self::$cache_key, self::$cache_expire_in_minutes, function () {
            return Gift::defaultSort()->get();
        });
    }

    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getImageUrlAttribute()
    {
        // 如果 image 字段本身就已经是完整的 url 就直接返回
        if (Str::startsWith($this->attributes['image'], ['http://', 'https://']))
        {
            return $this->attributes['image'];
        }
        return \Storage::disk('public')->url($this->attributes['image']);
    }
}
