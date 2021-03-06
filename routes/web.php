<?php

Route::get('test', function () {

//    $order = \App\Models\Order::find(8);
//
//    event(new \App\Events\OrderPaid($order));
//
//
//    return '1';
//    dd(session('LBS'));
});

Horizon::auth(function ($request) {
    return Auth::guard('admin')->check();
});
Auth::routes();
Route::redirect('/', '/exposures')->name('root');/*首页*/
//Route::get('/', 'PagesController@root')->name('root');


/*需要登录的路由*/
Route::group(['middleware' => 'auth'], function () {

    /*用户*/
    Route::get('users/released_exposures', 'UsersController@releasedExposures')->name('users.released_exposures');/*我发布的曝光*/
    Route::get('users/commented_exposures', 'UsersController@commentedExposures')->name('users.commented_exposures');/*我评论的曝光*/
    Route::get('users', 'UsersController@index')->name('users.index');/*用户中心*/
    Route::get('users/{user}/edit', 'UsersController@edit')->name('users.edit');/*修改资料*/
    Route::put('users/{user}', 'UsersController@update')->name('users.update');/*修改提交*/


    /*曝光*/
    Route::get('exposures/create', 'ExposuresController@create')->middleware('wechat.authorize')->name('exposures.create');/*曝光发布页面*/
    Route::post('exposures', 'ExposuresController@store')->name('exposures.store');/*曝光发布*/


    /*评论*/
    Route::post('exposure_comments', 'ExposureCommentsController@store')->name('exposure_comments.store');/*曝光评论*/

    /*支付*/
    Route::get('payment/gift/alipay', 'PaymentController@giftByAlipay')->name('payment.gift.alipay');/*赠送礼物(支付宝)*/
    Route::get('payment/gift/wechat_h5', 'PaymentController@giftByWechatH5')->name('payment.gift.wechat_h5');/*赠送礼物(微信支付H5)*/
    Route::get('payment/gift/wechat_mp', 'PaymentController@giftByWechatMp')->middleware('wechat.authorize')->name('payment.gift.wechat_mp');/*赠送礼物(微信支付公众号)*/

    /*微信公众号*/
    Route::get('wechat/authorize_notify', 'WechatController@wechatAuthorizeNotify')->name('wechat.authorize_notify');/*网页授权获取用户信息回调*/


});

/*用户*/
Route::post('phone_verification', 'PhoneVerificationController@store')->name('phone_verification.store');/*发送短信验证码*/
Route::get('locations/relocation', 'LocationsController@relocation')->name('locations.relocation');/*重新定位*/

/*曝光*/
Route::get('exposures', 'ExposuresController@index')->name('exposures.index');/*曝光台*/
Route::get('exposures/{exposure}', 'ExposuresController@show')->middleware('wechat.authorize')->name('exposures.show');/*曝光详情*/

/*新闻*/
Route::get('news', 'NewsController@index')->name('news.index');/*资讯中心*/
Route::get('news/{news}', 'NewsController@show')->name('news.show');/*资讯详情*/


/*支付回调*/
Route::post('payment/gift/alipay_notify', 'PaymentController@giftAlipayNotify')->name('payment.gift.alipay_notify');/*赠送礼物支付宝回调*/
Route::post('payment/gift/wechat_h5_notify', 'PaymentController@giftWechatH5Notify')->name('payment.gift.wechat_h5_notify');/*赠送礼物微信支付H5回调*/
Route::post('payment/gift/wechat_mp_notify', 'PaymentController@giftWechatMpNotify')->name('payment.gift.wechat_mp_notify');/*赠送礼物微信支付公众号回调*/
