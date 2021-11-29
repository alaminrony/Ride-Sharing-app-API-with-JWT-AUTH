<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
 */

Route::group([
    'middleware' => 'api',
        ], function ($router) {
    Route::post('phoneExists', 'Api\Driver\Auth\AuthController@phoneExists');
    Route::post('emailExists', 'Api\Driver\Auth\AuthController@emailExists');
    Route::post('socialIdExists', 'Api\Driver\Auth\AuthController@socialIdExists');
    Route::post('driver-registration', 'Api\Driver\Auth\AuthController@driverRegistration');
    Route::post('login', 'Api\Driver\Auth\AuthController@login');
    Route::post('logout', 'Api\Driver\Auth\AuthController@logout');
    Route::post('refresh', 'Api\Driver\Auth\AuthController@refresh');
    Route::get('profile', 'Api\Driver\Auth\AuthController@profile');
    Route::post('sendOtp', 'Api\Driver\Auth\AuthController@sendOTP');
    Route::post('verifyOtp', 'Api\Driver\Auth\AuthController@verifyOTP');
    Route::post('resetPassword', 'Api\Driver\Auth\AuthController@resetPassword');
    Route::get('verifyEmail/{email}', 'Api\Driver\Auth\AuthController@verifyEmail');
    Route::get('resendEmail/{email}', 'Api\Driver\Auth\AuthController@resendEmail');
    Route::post('addVehicle/', 'Api\Driver\Auth\AuthController@addVehicle');
    Route::post('vehicleList/', 'Api\Driver\Auth\AuthController@vehicleList');
    Route::get('vehicle/{id}', 'Api\Driver\Auth\AuthController@vehicle');
    Route::get('vehicleType', 'Api\Driver\Auth\AuthController@vehicleType');
    Route::post('selectVehicle/', 'Api\Driver\Auth\AuthController@selectVehicle');
    Route::post('editVehicle/', 'Api\Driver\Auth\AuthController@editVehicle');
    Route::post('deleteVehicle/', 'Api\Driver\Auth\AuthController@deleteVehicle');
    Route::post('onlineOffline/', 'Api\Driver\Auth\AuthController@onlineOffline');
    Route::post('loginPin/', 'Api\Driver\Auth\AuthController@loginPin');
    Route::post('resetPin/', 'Api\Driver\Auth\AuthController@resetPin');
    Route::post('helpAndSupport/', 'Api\Driver\Auth\AuthController@helpAndSupport');
    Route::post('editProfile/', 'Api\Driver\Auth\AuthController@editProfile');
    Route::post('updatePassword/', 'Api\Driver\Auth\AuthController@updatePassword');
    Route::post('requestRidesAdd/', 'Api\Driver\Auth\AuthController@requestRidesAdd');
    Route::post('requestRides/', 'Api\Driver\Auth\AuthController@requestRides');
    Route::get('rideDetails/{ride_id}', 'Api\Driver\Auth\AuthController@rideDetails')->name('rideDetails');
    Route::post('rideAccept/', 'Api\Driver\Auth\AuthController@rideAccept');
    Route::post('driverReachedAtPickup/', 'Api\Driver\Auth\AuthController@driverReachedAtPickup');
    Route::post('rideTimeOut/', 'Api\Driver\Auth\AuthController@rideTimeOut');
    Route::post('rideCancel/', 'Api\Driver\Auth\AuthController@rideCancel');
    Route::post('rideStart/', 'Api\Driver\Auth\AuthController@rideStart');
    Route::post('rideComplete/', 'Api\Driver\Auth\AuthController@rideComplete');
    Route::post('paymentComplete/', 'Api\Driver\Auth\AuthController@paymentComplete');
    Route::post('rideHistory/', 'Api\Driver\Auth\AuthController@rideHistory');
    Route::post('cancelHistory/', 'Api\Driver\Auth\AuthController@cancelHistory');
    Route::post('passengerRating/', 'Api\Driver\Auth\AuthController@passengerRating');
    Route::get('fareDetails/{ride_id}', 'Api\Driver\Auth\AuthController@fareDetails')->name('fareDetails');
    Route::post('cardAdd/', 'Api\Driver\Auth\AuthController@cardAdd');
    Route::post('cardList/', 'Api\Driver\Auth\AuthController@cardList');
    Route::post('cardUpdate/', 'Api\Driver\Auth\AuthController@cardUpdate');
    Route::post('cardDelete/', 'Api\Driver\Auth\AuthController@cardDelete');
    Route::post('billList/', 'Api\Driver\Auth\AuthController@billList');
    Route::post('todaySummary/', 'Api\Driver\Auth\AuthController@todaySummary');
    Route::post('todayFare/', 'Api\Driver\Auth\AuthController@todayFare');
    Route::post('home/', 'Api\Driver\Auth\AuthController@home');
    Route::post('deleteDriver/', 'Api\Driver\Auth\AuthController@deleteDriver');
    Route::post('driverDeviceAdd/', 'Api\Driver\Auth\AuthController@driverDeviceAdd');
    Route::post('driverNotifications/', 'Api\Driver\Auth\AuthController@driverNotifications');
    Route::post('readNotifications/', 'Api\Driver\Auth\AuthController@readNotifications');
    Route::post('changeEmail/', 'Api\Driver\Auth\AuthController@changeEmail');
    Route::get('cacheClear/', 'Api\Driver\Auth\AuthController@cacheClear');
    Route::get('taxiOperatorList/', 'Api\Driver\Auth\AuthController@taxiOperatorList');
    Route::get('driver/termAndPrivacy/', 'Api\Driver\Auth\AuthController@termAndPrivacy');
    Route::get('rideRequestDistance', 'Api\Driver\Auth\AuthController@reideRequestDistance');
    Route::get('driverCards/{id}', 'Api\Driver\Auth\AuthController@driverCards');
    Route::post('rideCancelReason/', 'Api\Driver\Auth\AuthController@rideCancelReason');
    Route::post('driverToken/', 'Api\Driver\Auth\AuthController@driverToken');
});


Route::group([
    'middleware' => 'api',
    'prefix' => 'passenger'
        ], function($router) {

    Route::post('passenger-registration', 'Api\Passenger\Auth\AuthController@passengerRegistration');
    Route::post('emailExists', 'Api\Passenger\Auth\AuthController@emailExists');
    Route::post('socialIdExists', 'Api\Passenger\Auth\AuthController@socialIdExists');
    Route::post('login', 'Api\Passenger\Auth\AuthController@login');
    Route::post('logout', 'Api\Passenger\Auth\AuthController@logout');
    Route::post('refresh', 'Api\Passenger\Auth\AuthController@refresh');
    Route::post('sendOtp', 'Api\Passenger\Auth\AuthController@sendOTP');
    Route::post('verifyOtp', 'Api\Passenger\Auth\AuthController@verifyOTP');
    Route::get('verifyEmail/{email}', 'Api\Passenger\Auth\AuthController@verifyEmail');
    Route::post('home/', 'Api\Passenger\Auth\AuthController@home');
    Route::get('resendEmail/{email}', 'Api\Passenger\Auth\AuthController@resendEmail');
    Route::post('resetPassword', 'Api\Passenger\Auth\AuthController@resetPassword');
    Route::post('editProfile/', 'Api\Passenger\Auth\AuthController@editProfile');
    Route::post('updatePassword/', 'Api\Passenger\Auth\AuthController@updatePassword');
    Route::get('profile', 'Api\Passenger\Auth\AuthController@profile');
    Route::post('driverRating/', 'Api\Passenger\Auth\AuthController@driverRating');
    Route::post('requestRidesAdd/', 'Api\Passenger\Auth\AuthController@requestRidesAdd');
    Route::post('phoneExists/', 'Api\Passenger\Auth\AuthController@phoneExists');
    Route::post('rideCancel/', 'Api\Passenger\Auth\AuthController@rideCancel');
    Route::post('rideCancelReason/', 'Api\Passenger\Auth\AuthController@rideCancelReason');
    Route::post('cardAdd/', 'Api\Passenger\Auth\AuthController@cardAdd');
    Route::post('cardList/', 'Api\Passenger\Auth\AuthController@cardList');
    Route::post('cardUpdate/', 'Api\Passenger\Auth\AuthController@cardUpdate');
    Route::post('cardDelete/', 'Api\Passenger\Auth\AuthController@cardDelete');
    Route::post('helpAndSupport/', 'Api\Passenger\Auth\AuthController@helpAndSupport');
    Route::post('rideHistory/', 'Api\Passenger\Auth\AuthController@rideHistory');
    Route::post('cancelHistory/', 'Api\Passenger\Auth\AuthController@cancelHistory');
    Route::get('fareDetails/{ride_id}', 'Api\Passenger\Auth\AuthController@fareDetails')->name('fareDetails');
    Route::post('addBill/', 'Api\Passenger\Auth\AuthController@addBill');
    Route::post('billList/', 'Api\Passenger\Auth\AuthController@billList');
    Route::post('deletePassengers/', 'Api\Passenger\Auth\AuthController@deletePassengers');
    Route::post('passengerDeviceAdd/', 'Api\Passenger\Auth\AuthController@passengerDeviceAdd');
    Route::post('passengerNotifications/', 'Api\Passenger\Auth\AuthController@passengerNotifications');
    Route::post('readNotifications/', 'Api\Passenger\Auth\AuthController@readNotifications');
    Route::post('estimateFare/', 'Api\Passenger\Auth\AuthController@estimateFare');
    Route::post('pickupArriving/', 'Api\Passenger\Auth\AuthController@pickupArriving');
    Route::post('reviewDetails/', 'Api\Passenger\Auth\AuthController@reviewDetails');
    Route::get('termAndPrivacy/', 'Api\Passenger\Auth\AuthController@termAndPrivacy');
    Route::post('changeEmail/', 'Api\Passenger\Auth\AuthController@changeEmail');
    Route::get('rideRequestDistance/', 'Api\Passenger\Auth\AuthController@reideRequestDistance');
    Route::get('passengerCards/{id}', 'Api\Passenger\Auth\AuthController@passengerCards');
    Route::post('passengerToken', 'Api\Passenger\Auth\AuthController@passengerToken');
});
