<?php

use App\Models\WorkingHour;
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
// Route::get('/show_otp/{number}','HomeController@showOtp')->name('showOtp');
// Route::get('/', 'HomeController@index')->name('front');
// Route::get('/login', 'Auth\LoginController@showLoginForm');
Route::middleware(['auth:web','verified'])->group( function() { 
// Route::get('/register_step','Auth\StepController@step2')->name('register_step2');
// Route::post('store_step2','Auth\StepController@store_step2')->name('store_step2');
// Route::get('/register_last_step','Auth\StepController@step3')->name('register_step3');
// Route::put('store_step3','Auth\StepController@store_step3')->name('store_step3');
// Route::post('hours','Auth\StepController@working_hours')->name('hours');
// Route::post('store_certificate','Auth\StepController@store_certificate')->name('store_certificate');
});

Route::prefix('admin')->group( function() {
	Auth::routes(['verify' => true]);
});

Route::group(['prefix' => 'admin','namespace' => 'Admin'], function () {
	//Change Language
	Route::get('lang/{locale}', 'HomeController@lang')->name('locale');
	Route::middleware(['auth:web','verified'])->group( function() {	

   //roles and permisisons
    Route::resource('roles','RoleController');
    Route::resource('permissions','PermissionController')->except(['show','edit','update']);
    
	//Home
    Route::get('/home', 'HomeController@index')->name('home');
	Route::get('/admin/{user}/edit','UserController@admin_edit')->name('admin_edit_profile');
	Route::put('admin/{user}','UserController@admin_update')->name('admin_update_profile');
	Route::post('/user/change_password/','UserController@change_password')->name('user_password_change');

	//user_status
	Route::resource('user', 'UserController');
	Route::post('/user/ajax', 'UserController@index_ajax')->name('dt_user');
	Route::post('/user/status', 'UserController@status')->name('user_status');

	// Route::post('/user/send_notification/','UserController@send_notification')->name('send_notification');
	Route::get('/export/','UserController@export')->name('user.export');

	// Route::post('/user/send_notification/','UserController@send_notification')->name('send_notification');
	Route::get('/export/','UserController@export')->name('user.export');

	// Settings
	Route::resource('setting','SettingController')->only(['index','create','store']);
	Route::post('setting/update/','SettingController@update')->name('setting.update');

	//Cms
	Route::resource('cms', 'CmsController');
	Route::post('/cms/status', 'CmsController@status')->name('cms_status');


    // ######## Gustos ############

    //sub_admin
    Route::resource('sub_admin', 'SubAdminController');
    Route::post('/sub_admin/ajax', 'SubAdminController@index_ajax')->name('dt_sub_admin');
    Route::post('/sub_admin/status','SubAdminController@status')->name('status_sub_admin');

    // Countries
    Route::resource('country', 'CountryController');
    Route::post('/country/ajax', 'CountryController@index_ajax')->name('dt_country');
    Route::post('/country/status', 'CountryController@status')->name('country_status');

    // States
    Route::resource('states', 'StateController');
    Route::post('/states/ajax', 'StateController@index_ajax')->name('dt_states');
    Route::post('/state/status', 'StateController@status')->name('status_states');
    Route::get('get_states/{country_id}', 'HomeController@get_state')->name('states.list');

    // Cities
    Route::resource('cities', 'CityController');
    Route::post('/cities/ajax', 'CityController@index_ajax')->name('dt_cities');
    Route::post('/city/status', 'CityController@status')->name('status_cities');


    //city_areas
    Route::resource('city_areas', 'CityAreaController');
    Route::post('/city_areas/ajax', 'CityAreaController@index_ajax')->name('dt_city_areas');
    Route::post('/city_areas/status', 'CityAreaController@status')->name('status_city_area');

    //crusts
    Route::resource('crusts', 'CrustController');
    Route::post('/crusts/ajax', 'CrustController@index_ajax')->name('dt_crusts');
    Route::post('/crusts/status', 'CrustController@status')->name('status_crust');

    //bases
    Route::resource('bases', 'BaseController');
    Route::post('/bases/ajax', 'BaseController@index_ajax')->name('dt_bases');
    Route::post('/bases/status', 'BaseController@status')->name('status_base');

    //toppings
    Route::resource('toppings', 'ToppingController');
    Route::post('/toppings/ajax', 'ToppingController@index_ajax')->name('dt_toppings');
    Route::post('/toppings/status', 'ToppingController@status')->name('status_topping');
    Route::post('/toppings/save_price', 'ToppingController@save_price')->name('toppings.save_price');
    

    //pizza Sizes
    Route::resource('pizza_sizes', 'PizzaSizeController');
    Route::post('/pizza_sizes/ajax', 'PizzaSizeController@index_ajax')->name('dt_pizza_sizes');
    Route::post('/pizza_sizes/status', 'PizzaSizeController@status')->name('status_pizza_size');

    //pizzas
    Route::resource('pizzas', 'PizzaController');
    Route::post('/pizzas/ajax', 'PizzaController@index_ajax')->name('dt_pizzas');
    Route::post('/pizzas/status', 'PizzaController@status')->name('status_pizza');

    //products
    Route::resource('products', 'ProductController');
    Route::post('/products/ajax', 'ProductController@index_ajax')->name('dt_products');
    Route::post('/products/status', 'ProductController@status')->name('status_product');
    Route::get('sent_notification_manually', 'ProductController@sent_notification_manually')->name('sent_notification_manually');
    //pizzas
    Route::resource('deals', 'DealController');
    Route::post('/deals/ajax', 'DealController@index_ajax')->name('dt_deals');
    Route::post('/deals/status', 'DealController@status')->name('status_deal');

    //Allergen Info
    Route::get('allergen_info_file', 'ProductController@get_allergen_info_file')->name('get_allergen_info_file');
    Route::post('allergen_info_file', 'ProductController@post_allergen_info_file')->name('post_allergen_info_file');

    //orders
    Route::resource('orders','OrderController');
    Route::post('/orders/ajax', 'OrderController@index_ajax')->name('ajax_orders');
    // Route::post('/orders/status', 'OrderController@status')->name('ordstatus');
    Route::post('/orders/update_status', 'OrderController@update_status')->name('orders.update_status');
    Route::post('/orders/cancel_order', 'OrderController@cancel_order')->name('orders.cancel_order');

    //order statuss
    Route::resource('orders_status','OrderStatusController');
    Route::post('/orders_status/ajax', 'OrderStatusController@index_ajax')->name('ajax_orders_status');
    // Route::post('/orders/status', 'OrderController@status')->name('ordstatus');
    Route::post('/orders_status/update_status', 'OrderStatusController@update_status')->name('orders_status.update_status');


    //vouchers
    Route::resource('vouchers', 'VoucherController');
    Route::post('/vouchers/ajax', 'VoucherController@index_ajax')->name('dt_vouchers');
    Route::post('/vouchers/status', 'VoucherController@status')->name('status_voucher');

    Route::get('working_hours','WorkingHourController@create')->name('working_hours');
    Route::post('working_hours','WorkingHourController@store')->name('working_hours_save');



    
    
    //customer
    Route::resource('customers','CustomerController');
    Route::post('/customers/ajax', 'CustomerController@index_ajax')->name('ajax_customers');
    Route::post('/customers/status', 'CustomerController@status')->name('status');
    Route::post('/customers/send_notification/','CustomerController@send_notification')->name('send_notification');

    // Contact Us
    Route::resource('contact_us', 'ContactUsController');
    Route::post('/contactus/ajax', 'ContactUsController@index_ajax')->name('ajax_contact_us');
    Route::post('/contact/status', 'ContactUsController@status')->name('contact_status');
    Route::post('contact_us/r_status','ContactUsController@r_status')->name('r_status');//r - resolved status 

    
    // Faqs Admin Side
    Route::resource('faqs', 'FaqController');
    Route::post('/faqs/ajax', 'FaqController@index_ajax')->name('ajax_faq');
    Route::post('/faqs/status', 'FaqController@status')->name('faq_status');

    // Enquiries Admin Side
    Route::resource('enquiries', 'EnquiryController');
    Route::post('/enquiries/ajax', 'EnquiryController@index_ajax')->name('ajax_enquiry');

    
    //Admin and Vendor profiles
    Route::get('/profile', 'ProfileController@profile')->name('profile');
    Route::post('/profile/update', 'ProfileController@update_profile')->name('update_profile');


    });

    Route::post('get_notification', 'NotificationController@get_notification')->name('get_notification');
    Route::get('get_order_beep', 'NotificationController@get_order_beep')->name('get_order_beep');


    // Notification
    Route::resource('notifications', 'NotificationController');
    // Route::post('notification/status','VendorNotificationController@status')->name('status_tier_package');
    Route::post('/notifications/ajax', 'NotificationController@index_ajax')->name('dt_notification');

 
});
//SUPPORT
Route::get('clear-cache/all', 'CacheController@clear_cache');
Route::get('rnd/pro/abc', 'CacheController@rnd');


Route::fallback(function () {
    // Redirect to a specific URL
    return redirect('/');
});