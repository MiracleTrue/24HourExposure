<?php

namespace App\Http\Controllers;

use App\Exceptions\InternalException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PhoneVerificationController extends Controller
{
    /**
     * @param Request $request
     * @return array
     * @throws InternalException
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'phone' => [
                'required',
                'regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199|(147))\d{8}$/'
            ],
        ], [], [
            'phone' => '手机号',
        ]);

        // 生成6位随机数，左侧补0
        $code = str_pad(random_int(1, 999999), 6, 0, STR_PAD_LEFT);

        $key = 'PhoneVerificationCode_' . $data['phone'];
        $expiredAt = now()->addMinutes(5);
        // 缓存验证码 x分钟过期。
        \Cache::put($key, ['phone' => $data['phone'], 'code' => $code], $expiredAt);


        $sms = app('easysms');
        try
        {
            $sms->send($data['phone'], [
                'content' => $code . '为您的注册验证码，如非本人操作，请忽略本短信。',
            ]);
        } catch (\Exception $exception)
        {
            Log::error($exception->getException('qcloud')->getMessage());
            throw new InternalException($exception->getException('qcloud')->getMessage());
        }

        return [];
    }
}
