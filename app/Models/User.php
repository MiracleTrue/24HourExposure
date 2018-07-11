<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;


    protected $fillable = [
        'phone', 'name', 'avatar', 'password', 'id_card'
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['avatar_url'];


    public function getAvatarUrlAttribute()
    {
        // 如果 image 字段本身就已经是完整的 url 就直接返回
        if (Str::startsWith($this->attributes['avatar'], ['http://', 'https://']))
        {
            return $this->attributes['avatar'];
        }
        return \Storage::disk('public')->url($this->attributes['avatar']);
    }
}
