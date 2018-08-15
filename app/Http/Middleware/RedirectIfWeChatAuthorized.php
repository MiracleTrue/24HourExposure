<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

/*如果未微信授权则重定向*/

class RedirectIfWeChatAuthorized
{
    /**
     * Handle an incoming request.
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!$request->session()->has('wechat_user'))
        {
            $app = app('wechat.official_account');

            $request->session()->put('target_url', url()->previous());

            $response = $app->oauth->scopes([
                'scopes' => ['snsapi_userinfo'],
                'callback' => '/wechat/authorize_notify'
            ])->redirect();

            return $response;
        }

        return $next($request);
    }
}
