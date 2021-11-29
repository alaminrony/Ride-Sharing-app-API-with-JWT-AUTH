<?php

namespace App\Http\Controllers\Auth\Login;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;


// namespace App\Http\Controllers\Auth\Login;
// use Illuminate\Support\Facades\Auth;
// use App\Http\Controllers\Auth\LoginController as DefaultLoginController;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
// class DriverController extends DefaultLoginController
{
	 use AuthenticatesUsers;

     protected $redirectTo = '/driver/home';

    public function __construct()
    {
    	 $this->middleware('guest')->except('logout');
        // $this->middleware('guest:driver')->except('logout');
    }
    public function guard()
    {
     return Auth::guard('driver');
    }
    public function showLoginForm()
    {
        return view('driver.auth.login');
    }
    public function username()
    {
        return 'd_email';
    }
    // protected function guard()
    // {
    //     return Auth::guard('driver');
    // }
}
