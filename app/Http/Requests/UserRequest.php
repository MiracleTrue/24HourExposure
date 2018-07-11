<?php

namespace App\Http\Requests;


class UserRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:20',
            'avatar' => 'sometimes|image'
        ];
    }

    public function attributes()
    {
        return [
            'name' => '用户名',
            'avatar' => '头像',
        ];
    }
}
