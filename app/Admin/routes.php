<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {
    $router->post('wang_editor/images', 'WangEditorController@images');/*WangEditor上传图片*/


    $router->get('/', 'HomeController@index');

    $router->get('users', 'UsersController@index')->name('admin.users.index');


    $router->resource('news_categories', NewsCategoriesController::class);

    $router->resource('news', NewsController::class);
});
