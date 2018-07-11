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


//Route::put('users/{user}', 'UsersController@update')->name('users.update');//修改提交



Route::post('phone_verification', 'PhoneVerificationController@store')->name('phone_verification.store');//发送短信验证码
Route::get('locations/relocation', 'LocationsController@relocation')->name('locations.relocation');//重新定位

/*需要登录的路由*/
Route::group(['middleware' => 'auth'], function () {

    /*用户*/
    Route::get('users', 'UsersController@index')->name('users.index');//用户中心
    Route::get('users/{user}/edit', 'UsersController@edit')->name('users.edit');//修改资料
    Route::put('users/{user}', 'UsersController@update')->name('users.update');//修改提交


    /*曝光*/



});
