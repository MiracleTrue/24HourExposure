<?php

namespace App\Http\Requests;


use Illuminate\Support\Facades\Validator;

class GiftByAlipayRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'exposure_id' => ['required', 'exists:exposures,id'],
            'gifts' => ['required', 'json', function ($key, $json, $fail) {

                $val = json_decode($json, true);

                if (empty($val))
                {
                    $fail('礼物JSON 不能为空');
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
            'exposure_id' => '曝光',
            'gifts' => '礼物JSON',
        ];
    }
}
