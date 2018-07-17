<?php

Route::get('test', function () {

    $order = \App\Models\Order::find(8);

    event(new \App\Events\OrderPaid($order));


    return '1';
    dd(session('LBS'));
});


Auth::routes();
Route::redirect('/', '/users')->name('root');
//Route::get('/', 'PagesController@root')->name('root');


Route::post('phone_verification', 'PhoneVerificationController@store')->name('phone_verification.store');//发送短信验证码
Route::get('locations/relocation', 'LocationsController@relocation')->name('locations.relocation');//重新定位

/*新闻*/
Route::get('news', 'NewsController@index')->name('news.index');//资讯中心
Route::get('news/{news}', 'NewsController@show')->name('news.show');//资讯详情


/*曝光*/
Route::get('exposures', 'ExposuresController@index')->name('exposures.index');//曝光台
Route::get('exposures/{exposure}', 'ExposuresController@show')->name('exposures.show');//曝光详情


//需要登录的路由
Route::group(['middleware' => 'auth'], function () {

    /*用户*/
    Route::get('users', 'UsersController@index')->name('users.index');//用户中心
    Route::get('users/{user}/edit', 'UsersController@edit')->name('users.edit');//修改资料
    Route::put('users/{user}', 'UsersController@update')->name('users.update');//修改提交


    /*曝光*/


    /*评论*/
    Route::post('exposure_comments', 'ExposureCommentsController@store')->name('exposure_comments.store');//曝光评论

    /*支付*/
    Route::post('payment/gift/alipay', 'PaymentController@giftByAlipay')->name('payment.gift.alipay');/*赠送礼物*/

});

//支付回调
Route::post('payment/gift/alipay_notify', 'PaymentController@giftAlipayNotify')->name('payment.gift.alipay_notify');
