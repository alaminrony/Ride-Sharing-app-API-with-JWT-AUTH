<?php

namespace App\Http\Controllers\Auth\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class PassengerController extends Controller
{
    use AuthenticatesUsers;

     protected $redirectTo = '/passenger/home';

    public function __construct()
    {
    	 $this->middleware('guest')->except('logout');
    }
    public function guard()
    {
     return Auth::guard('passenger');
    }
    public function showLoginForm()
    {
        return view('passenger.auth.login');
    }
    public function username()
    {
        return 'p_email';
    }

}
