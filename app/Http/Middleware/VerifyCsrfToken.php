<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     * @var array
     */
    protected $except = [
        //
        'wechat',
        'payment/gift/alipay_notify',
        'payment/gift/wechat_h5_notify',
        'payment/gift/wechat_mp_notify',
    ];
}
