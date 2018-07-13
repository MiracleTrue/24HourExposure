<?php

namespace App\Http\Requests;

class ExposureCommentRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'exposure_id' => 'required|exists:exposures,id',
            'content' => 'required|string'
        ];
    }

    public function attributes()
    {
        return [
            'exposure_id' => '曝光',
            'content' => '评论内容',
        ];
    }
}
