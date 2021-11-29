<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::get('mailvarification/{id}/{code}' ,'admin\UserController@mailvarification');

// driver login authentication :start 
Route::get('/driver/login', 'Auth\Login\DriverController@showLoginForm')->name('driver.login');
Route::post('/driver/login', 'Auth\Login\DriverController@login')->name('driver.login.post');
Route::post('/driver/logout', 'Auth\Login\DriverController@logout')->name('driver.logout');

// Driver profile routes

Route::group(['middleware'=>'driver'], function() {
    Route::get('/driver/home', 'Driver\DriverHomeController@index');
});
// driver login authentication :end 

// passenger login authentication :start 
Route::get('/passenger/login', 'Auth\Login\PassengerController@showLoginForm')->name('passenger.login');
Route::post('/passenger/login', 'Auth\Login\PassengerController@login')->name('passenger.login.post');
Route::post('/passenger/logout', 'Auth\Login\PassengerController@logout')->name('passenger.logout');

// passenger profile routes

Route::group(['middleware'=>'passenger'], function() {
    Route::get('/passenger/home', 'Passenger\PassengerHomeController@index');
});
// passenger login authentication :end 

Route::group(['middleware' => 'auth', 'checkStatus'], function () {
	Route::get('/dashboard', 'HomeController@index')->name('home');

	// cab type
	Route::resource('cab-body-type','admin\CabTypeController');
	// cab
	Route::get('cab/driver/search','admin\CabController@dsearch')->name('cab.dsearch');
	Route::resource('cab','admin\CabController');
	// passenger
	Route::get('passenger/{id}/trash','admin\PassengerController@trash')->name('passenger.trash');
	Route::get('passenger/trash','admin\PassengerController@trashlist')->name('passenger.trashlist');
	Route::get('passenger/inactive','admin\PassengerController@inactive')->name('passenger.inactive');
	Route::resource('passenger','admin\PassengerController');
	// driver
	Route::get('driver/{id}/trash','admin\DriverController@trash')->name('driver.trash');
	Route::get('driver/trash','admin\DriverController@trashlist')->name('driver.trashlist');
	Route::get('driver/inactive','admin\DriverController@inactive')->name('driver.inactive');
	Route::resource('driver', 'admin\DriverController');
	// driver log
	Route::get('driver-log/filter','admin\DriverActivityLogController@filter');
	Route::resource('driver-log','admin\DriverActivityLogController');
	// driver bill
	Route::get('driver-bill/search','admin\DriverBillController@search');
	Route::resource('driver-bill','admin\DriverBillController');

	// Bill charge option
	Route::resource('bill-options','admin\BillChargeOptionController');
	// Bill charge sub option
	Route::resource('bill-options-value','admin\BillChargeOptionValueController');
	// Bill Settings

	Route::get('bill-settings/option','admin\BillSettingsController@option')->name('bill-settings.option');
	Route::resource('bill-settings','admin\BillSettingsController');
	// bill settings log
	Route::resource('bill-settings-log','admin\BillSettingsLogController');
	// Our services
	Route::resource('our-services','admin\OurServiceController');
	// Notification
	Route::resource('notification','admin\NotificationController');
	// news category
	Route::resource('news-category','admin\NewsCategoryController');
	// NEWS
	Route::get('news/{id}/trash','admin\NewsController@trash')->name('news.trash');
	Route::get('news/trash','admin\NewsController@trashlist')->name('news.trashlist');
	
	Route::resource('news','admin\NewsController');
	// subscriber
	Route::resource('subscriber','admin\SubscriberController');
	// contact
	Route::resource('contact','admin\ContactUsController');
	// Slider
	Route::resource('slider','admin\MainSliderController');
	// Ride Apps
	Route::resource('ride-apps','admin\RideAppsController');
	// Settings
	Route::resource('settings','admin\SettingsController');
	// cab ride
	Route::get('cab-ride/pending-rides','admin\CabRideController@pending');
	Route::get('cab-ride/filter','admin\CabRideController@filter');
	Route::get('cab-ride/discount','admin\CabRideController@discount');
	Route::resource('cab-ride','admin\CabRideController');
	// cancel ride
	Route::resource('ride-cancel','admin\RideCancelController');
	// cancel issue
	Route::resource('cancel-issue','admin\CancelIssueController');
	// user
	Route::resource('user', 'admin\UserController');
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

Route::group(['middleware' => 'auth'], function () {
	Route::get('{page}', ['as' => 'page.index', 'uses' => 'PageController@index']);
});


// driver authentication

// Route::prefix('driver')
//     ->as('driver.')
//     ->group(function() {
//         Route::get('home', 'Driver\DriverHomeController@index')->name('home');
// Route::namespace('Auth\Login')
//       ->group(function() {
//        Route::get('driver/login', 'DriverController@showLoginForm')->name('login');
//     Route::post('login', 'DriverController@login')->name('login');
//     Route::post('logout', 'DriverController@logout')->name('logout');
//       });
//  });

// Route::get('/driver/home','Driver\DriverHomeController@index')->name('driver.home');

// Route::get('driver/login', 'Auth\Login\DriverController@showLoginForm')->name('login');