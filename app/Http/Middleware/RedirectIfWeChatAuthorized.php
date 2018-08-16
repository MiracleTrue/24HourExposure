<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        Log::debug($request->session()->get('wechat_user'));

        if (!$request->session()->has('wechat_user'))
        {
            $app = app('wechat.official_account');

            $request->session()->put('target_url', url()->previous());

            $response = $app->oauth->scopes(['snsapi_userinfo'])
                ->redirect();

            return $response;
        }

        return $next($request);
    }
}
