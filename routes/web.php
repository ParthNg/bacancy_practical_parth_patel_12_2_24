<?php

use Illuminate\Support\Facades\Route;

include 'customer.php'; 

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


Route::prefix('admin')->group( function() {
	Auth::routes(['verify' => true]);
});

Route::group(['prefix' => 'admin','namespace' => 'Admin'], function () {
	Route::middleware(['auth:web','verified'])->group( function() {	    
        //Home
        Route::get('/home', 'HomeController@index')->name('home');
        
        // Configurations
        Route::resource('setting','SettingController')->only(['index','create','store']);
        Route::post('setting/update/','SettingController@update')->name('setting.update');

        //products
        Route::resource('products', 'ProductController');
        Route::post('/products/ajax', 'ProductController@index_ajax')->name('dt_products');
        Route::post('/products/status', 'ProductController@status')->name('status_product');
        Route::get('sent_notification_manually', 'ProductController@sent_notification_manually')->name('sent_notification_manually');
    });
});

//SUPPORT
Route::get('clear-cache/all', 'CacheController@clear_cache');

Route::fallback(function () {
    // Redirect to a specific URL
    return redirect('/');
});