<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
     */
    public function __construct()
    {
        // get previous URL
        intendedURL();

        $this->middleware('guest')->except('logout');
    }

    /**
     * Override Attribute redirectTo.
     */
    public function redirectTo()
    {
        // CHECK USER IS ADMIN THEN REDRIECT TO ADMIN DASHBOARD
        // if (Auth::check() && 1 == Auth::user()->role->id) {
        //     return $this->redirectTo = route('admin.dashboard');
        // }

        return Session::has('pre_url') ? Session::get('pre_url') : $this->redirectTo;
    }
}
