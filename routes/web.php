<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('test', function () {

    dd(session('LBS'));
});

Auth::routes();
Route::get('/', 'PagesController@root')->name('root');

Route::post('phone_verification', 'PhoneVerificationController@store')->name('phone_verification.store');//发送短信验证码

/*需要登录的路由*/
Route::group(['middleware' => 'auth'], function () {


});
