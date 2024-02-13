<?php

/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::namespace('Customer')->group(function() {


  //Home Page
  Route::get('/', 'HomeController@web_index')->name('app');
	Route::get('/home', 'HomeController@web_index')->name('web_home');
  
}); 

