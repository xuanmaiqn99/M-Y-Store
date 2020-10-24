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

use Illuminate\Http\Request;

// route for auth
Auth::routes();

// route for site
Route::group(['namespace' => 'Site'], function () {
    Route::get('/', 'HomeController@index')->name('site.home.index');
    Route::get('category/{id}/index', 'CategoryController@index')->name('site.category.index');
    Route::get('index', 'HomeController@index')->name('site.home.index');
    Route::get('search', 'HomeController@search')->name('site.home.search');
    Route::get('multiple/search', 'HomeController@searchMul')->name('site.home.search_mul');
    Route::get('seggest/{id?}', 'HomeController@seggest')->name('site.home.seggest');
    Route::get('product/{id}/view', 'ProductController@view')->name('product.view');
    Route::post('check-login', 'HomeController@checkLogIn')->name('site.home.check_login');
    Route::post('order/add', 'OrderController@add')->name('site.order.add');
    Route::get('order/success', 'OrderController@success')->name('site.order.success');
    Route::post('order/check-order', 'OrderController@checkOrder')->name('site.order.check');
    Route::group([], function () {
        Route::get('customer/login', 'CustomerController@logIn')->name('site.customer.login');
        Route::post('customer/login', 'CustomerController@postLogIn');
        Route::get('customer/reset', 'CustomerController@reset')->name('site.customer.reset');
        Route::post('customer/reset', 'CustomerController@handleReset')->name('site.customer.handle_reset');
        Route::post('customer/check-login', 'CustomerController@checkLogIn')->name('site.customer.check_login');
        Route::post('customer/review', 'CustomerController@review')->name('site.customer.review');
        Route::get('customer/logout', 'CustomerController@logOut')->name('site.customer.logout');
        Route::get('customer/regester', 'CustomerController@regester')->name('site.customer.regester')->middleware('guest');
        Route::get('customer/order-history', 'CustomerController@history')->name('site.customer.history');
        Route::post('customer/order-detail-history', 'CustomerController@historyDetail')->name('site.customer.history_detail');
        Route::resource('customer', 'CustomerController', ['as' => 'site', 'except' => 'destroy']);
    });
    Route::group(['prefix' => 'contact'], function () {
        Route::get('index', 'ContactController@index')->name('site.contact.index');
        Route::post('index', 'ContactController@store')->name('site.contact.create');
    });
    Route::group(['prefix' => 'news'], function () {
        Route::get('index', 'NewsController@index')->name('site.news.index');
        Route::get('{id}/chi-tiet', 'NewsController@view')->name('site.news.view');
        Route::get('search', 'NewsController@search')->name('site.news.search');
    });
    Route::group(['prefix' => 'comment'], function () {
        Route::post('/store', 'CommentController@store')->name('comment.add');
        Route::post('/reply/store', 'CommentController@replyStore')->name('reply.add');
    });
    Route::group(['prefix' => 'cart'], function () {
        Route::post('add-to-compare', 'CartController@addToCompare')->name('site.cart.add_to_compare');
        Route::post('delete-product-compare', 'CartController@deleteProductCompare')->name('site.cart.delete_product_compare');
        Route::get('view-to-wishlist', 'CartController@viewWishList')->name('site.cart.view_to_wishlist')->middleware('login_site');
        Route::post('add-to-wishlist', 'CartController@addToWishList')->name('site.cart.add_to_wishlist');
        Route::post('delete-product-wishlist', 'CartController@removeWishList')->name('site.cart.delete_product_wishlist');
        Route::get('view-to-compare', 'CartController@viewToCompare')->name('site.cart.view_to_compare');
        Route::get('view', 'CartController@index')->name('site.cart.view')->middleware('login_site');
        Route::get('checkout', 'CartController@checkOut')->name('site.cart.checkout')->middleware('login_site');
        Route::post('add', 'CartController@add')->name('site.cart.add');
        Route::post('add-to-cart', 'CartController@addToCart')->name('site.cart.add_to_cart');
        Route::post('delete', 'CartController@delete')->name('site.cart.delete');
        Route::post('update', 'CartController@update')->name('site.cart.update')->middleware('login_site');
    });
});

// route for admin
Route::group(['prefix' => 'admin', 'middleware' => 'admin_login', 'namespace' => 'Admin'], function () {
    Route::get('home/index', 'HomeController@index')->name('home.index');
    Route::get('logout', 'AdminController@getLogout')->name('admin.logout');
    Route::get('{id}/notification', 'NotificationController@view')->name('notif.view');
    Route::get('notification', 'NotificationController@viewAll')->name('notif.view_all');
    Route::group(['prefix' => 'admin'], function () {
        Route::get('index', 'AdminController@index')->name('admin.index');
        Route::get('{id}/edit', 'AdminController@edit')->name('admin.edit');
        Route::post('{id}/update', 'AdminController@update')->name('admin.update');
    });

    Route::group(['prefix' => 'order'], function () {
        Route::post('export-to-excel', 'OrderController@exportToExcel')->name('order.export_to_excel');
        Route::get('index', 'OrderController@index')->name('order.index');
        Route::get('{id}/detail', 'OrderController@detail')->name('order.detail');
        Route::post('delete', 'OrderController@delete')->name('order.delete');
        Route::post('confirm-order', 'OrderController@confirmOrder')->name('order.confirm_order');
    });

    Route::group([], function () {
        Route::resource('customer', 'CustomerController', ['except' => 'destroy']);
        Route::post('customer/delete', 'CustomerController@delete')->name('customer.delete');
        Route::post('customer/deleteMulCus', 'CustomerController@delMulCustomer')->name('customer.delMulCus');
        Route::get('customer-restore', 'CustomerController@restore')->name('customer.restore');
    });

    Route::group([], function () {
        Route::resource('news', 'NewsController', ['except' => 'destroy']);
        Route::post('news/{id}/delete', 'NewsController@delete')->name('news.delete');
        Route::post('news/deleteMulNews', 'NewsController@delMulNews')->name('news.delMulNews');
    });

    Route::group(['prefix' => 'contact'], function () {
        Route::get('index', 'ContactController@index')->name('contact.index');
        Route::post('delete', 'ContactController@delete')->name('contact.delete');
        Route::post('deleteMulCon', 'ContactController@delMulCon')->name('contact.delMulCon');
    });

    Route::group(['prefix' => 'comment'], function () {
        Route::get('index', 'CommentController@index')->name('comment.index');
        Route::get('{id}/chi-tiet', 'CommentController@view')->name('comment.view');
        Route::post('delete-reply', 'CommentController@deleteReply')->name('comment.delMulRep');
        Route::post('delete-comment', 'CommentController@delete')->name('comment.delMulCom');
    });

    Route::group([], function () {
        Route::get('delete/{id}', 'SlideController@delete')->name('slide.delete');
        Route::resource('slide', 'SlideController', ['except' => ['show', 'destroy']]);
    });

    Route::group([], function () {
        Route::resource('category', 'CategoryController', ['except' => 'destroy']);
        Route::post('category/delete', 'CategoryController@delete')->name('category.delete');
        Route::post('category/checkChild', 'CategoryController@checkChild')->name('category.checkChild');
        Route::get('category-restore', 'CategoryController@restore')->name('category.restore');
    });

    Route::group([], function () {
        Route::resource('product', 'ProductController', ['except' => ['show', 'destroy']]);
        Route::post('delete', 'ProductController@delete')->name('product.delete');
        Route::post('deleteMulProd', 'ProductController@delMulProd')->name('product.delMulProd');
        Route::get('product-restore', 'ProductController@restore')->name('product.restore');
    });
});
Route::get('admin/login', 'Admin\AdminController@getLogin')->name('admin.login');
Route::post('admin/login', 'Admin\AdminController@postLogin');

// route for anything unmatch
Route::any('{all}', function (Request $request) {
    if (strpos($request->url(), 'admin') > 0) {
        return view('admin.404');
    }

    return view('site.404');
})->where('all', '.*');
