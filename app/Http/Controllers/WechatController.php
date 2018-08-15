<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WechatController extends Controller
{

    public function wechatAuthorizeNotify(Request $request)
    {
        $app = app('wechat.official_account');

        // 获取 OAuth 授权结果用户信息
        $user = $app->oauth->user();

        // 将授权结果用户信息存入Session
        $request->session()->put('wechat_user', $user->toArray());

        // 获取来源页面地址
        $target_url = $request->session()->get('target_url', route('root'));

        return redirect($target_url);
    }
}
