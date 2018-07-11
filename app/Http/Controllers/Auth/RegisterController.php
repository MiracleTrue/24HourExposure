<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $verifyData = \Cache::get('PhoneVerificationCode_' . $data['phone']);


        return Validator::make($data, [
            'phone' => [
                'required',
                'regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199|(147))\d{8}$/',
                'unique:users,phone'
            ],
            'password' => 'required|string|min:6|confirmed',
            'verification_code' => 'required|numeric|in:' . $verifyData['code'],
            'id_card' => [
                'required',
                'regex:/(^[1-9]\d{5}(18|19|([23]\d))\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$)|(^[1-9]\d{5}\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{2}[0-9Xx]$)/',
            ]
        ], [
            'verification_code.in' => '短信验证码 不正确'
        ], [
            'phone' => '手机号',
            'verification_code' => '短信验证码',
            'id_card' => '身份证号码'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     * @param array $data
     * @return User|\Illuminate\Database\Eloquent\Model
     */
    protected function create(array $data)
    {
        return User::create([
            'phone' => $data['phone'],
            'avatar' => '',
            'name' => '默认用户名',
            'password' => bcrypt($data['password']),
            'id_card' => $data['id_card'],
        ]);
    }
}
