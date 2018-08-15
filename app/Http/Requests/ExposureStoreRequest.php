<?php

namespace App\Http\Requests;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class ExposureStoreRequest extends Request
{

    public function rules()
    {
        return [
            'category_id' => ['required', 'exists:exposure_categories,id'],
            'name' => ['required', 'unique:exposures,name'],
            'title' => ['required'],
            'content' => ['required'],
            'pay_method' => ['in:' . Order::PAYMENT_METHOD_WECHAT_H5 . ',' . Order::PAYMENT_METHOD_ALIPAY],
            'gifts' => ['sometimes', 'required', 'json', function ($key, $json, $fail) {

                $val = json_decode($json, true);

                if (empty($val))
                {
                    return $fail('礼物JSON 不能为空');
                }

                Validator::validate($val, [
                    '*.id' => ['required', 'exists:gifts,id'],
                    '*.number' => ['required', 'integer', 'min:1'],
                ], [], [
                    '*.id' => '礼物',
                    '*.number' => '礼物数量',
                ]);
            }]
        ];
    }

    public function attributes()
    {
        return [
            'category_id' => '分类',
            'name' => '曝光对象',
            'title' => '曝光标题',
            'content' => '曝光内容',
            'pay_method' => '支付方式',
            'gifts' => '礼物JSON',
        ];
    }

}
