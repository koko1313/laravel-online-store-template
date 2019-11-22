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

Route::get('/', function () { return view('index'); })->name('index');
Route::get('contact', 'ContactController@form')->name('contact');
Route::post('contact', 'ContactController@send');

Route::prefix('user')->group(function () {
    Route::group(['middleware' => 'guest', 'namespace' => 'Users'], function () {
        Route::get('login', 'LoginController@form')->name('login');
        Route::post('login', 'LoginController@login');
        Route::get('register', 'RegisterController@form')->name('register');
        Route::post('register', 'RegisterController@register');
    });

    Route::group(['middleware' => 'auth', 'namespace' => 'Users'], function () {
        Route::get('profile', 'ProfileController@index')->name('profile');
        Route::put('profile', 'ProfileController@update');
        Route::get('logout', 'LoginController@logout')->name('logout');
    });
});

Route::prefix('carousel')->middleware('adminCheck')->group(function () {
    Route::get('form', 'CarouselController@create')->name('carousel.add');
    Route::post('form', 'CarouselController@store');
    Route::get('edit/{id}', 'CarouselController@edit')->name('carousel.edit');
    Route::put('edit/{id}', 'CarouselController@update');
    Route::delete('delete/{id}', 'CarouselController@delete')->name('carousel.delete');
});

Route::prefix('shop')->group(function () {
    Route::group(['namespace' => 'Shop'], function () {
        Route::get('/', 'ShopController@index')->name('shop');

        Route::prefix('category')->group(function () {
            Route::group(['middleware' => 'adminCheck'], function () {
                Route::get('form', 'CategoryController@form')->name('category.add');
                Route::post('form', 'CategoryController@store');
                Route::get('edit/{id}', 'CategoryController@edit')->name('category.edit');
                Route::put('edit/{id}', 'CategoryController@update');
                Route::get('delete/{id}', 'CategoryController@delete')->name('category.delete');
            });
            Route::get('/{id?}', 'ShopController@openCategory')->name('open.category');
        });

        Route::prefix('product')->group(function () {
            Route::group(['middleware' => 'adminCheck'], function () {
                Route::get('form', 'ProductController@form')->name('product.add');
                Route::post('form', 'ProductController@store');
                Route::get('edit/{id}', 'ProductController@edit')->name('product.edit');
                Route::put('edit/{id}', 'ProductController@update');
                Route::get('delete/{id}', 'ProductController@delete')->name('product.delete');
                Route::get('/{product_id}/delete_image/{image}', 'ProductController@delete_image')->name('product.delete_image');
            });
            Route::get('/{id?}', 'ShopController@openProduct')->name('open.product');
        });

        Route::prefix('cart')->middleware('auth')->group(function () {
            Route::get('/', 'CartController@open')->name('cart');
            Route::post('/', 'CartController@add');
            Route::get('/remove_product/{id}', 'CartController@remove')->name('cart.remove.product');
            Route::get('/make_order', 'CartController@make_order')->name('make.order');
            Route::post('/make_order', 'CartController@finalize_order');
        });

        Route::prefix('manage_orders')->group(function () {
            Route::group(['middleware' => 'adminCheck'], function () {
                Route::get('/', 'OrdersController@open')->name('manage_orders');
                Route::get('/finish_order/{id}', 'OrdersController@finish_order')->name('finish.order');
                Route::get('/restore_order/{id}', 'OrdersController@restore_order')->name('restore.order');
                Route::get('/delete_order/{id}', 'OrdersController@delete_order')->name('delete.order');
                Route::get('/order/{id}', 'OrdersController@view_order')->name('view.order');
                Route::get('/remove_product/{order_id}/{product_id}', 'OrdersController@remove_product')->name('order.remove.product');
            });
        });
    });
});

