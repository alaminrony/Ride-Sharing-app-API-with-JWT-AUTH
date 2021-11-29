<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


// use Illuminate\Http\Request;
//     use Auth;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['guest','checkstatus'])->except('logout');
        // $this->middleware('guest:driver')->except('driver.logout');
    }

    // public function showDriverLoginForm()
    // {
    //     return view('auth.login', ['url' => 'driver']);
    // }

    // public function driverLogin(Request $request)
    // {
    //     $this->validate($request, [
    //         'd_email'   => 'required|email',
    //         'password' => 'required|min:6'
    //     ]);

    //     if (Auth::guard('driver')->attempt(['d_email' => $request->d_email, 'password' => $request->password], $request->get('remember'))) {

    //         return redirect()->intended('/driver-admin');
    //     }
    //     return back()->withInput($request->only('d_email', 'remember'));
    // }


}
