<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {
    $router->post('wang_editor/images', 'WangEditorController@images');/*WangEditor上传图片*/

//    $router->redirect('/', 'users');
    $router->get('/', 'HomeController@index');


    $router->get('users', 'UsersController@index')->name('admin.users.index');


    $router->resource('news_categories', NewsCategoriesController::class);


    $router->resource('news', NewsController::class);


    $router->resource('exposure_categories', ExposureCategoriesController::class);


    $router->get('exposures', 'ExposuresController@index')->name('exposures.index');
    $router->get('exposures/{id}', 'ExposuresController@show')->name('exposures.show');
    $router->get('exposure_comments/{exposure}', 'ExposureCommentsController@index')->name('exposure_comments.index');


    $router->resource('gifts', GiftController::class);


//    $router->resource('example', ExampleController::class);
//    $router->get('example', 'ExampleController@index')->name('example.index');
//    $router->get('example/{id}', 'ExampleController@show')->name('example.show');
//    $router->get('example/create', 'ExampleController@create')->name('example.create');
//    $router->get('example/{id}/edit', 'ExampleController@edit')->name('example.edit');
//    $router->post('example', 'ExampleController@store')->name('example.store');
//    $router->put('example/{id}', 'ExampleController@update')->name('example.update');
//    $router->delete('example/{id}', 'ExampleController@destroy')->name('example.destroy');
});
