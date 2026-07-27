<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

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
    // protected $redirectTo = '/home';
    protected function authenticated()
    {
        if (Auth::user()->role_as == '1') { // Admin
            return redirect()->route('admin.dashboard')->with('status', 'Welcome to Admin Dashboard');
        } elseif (Auth::user()->role_as == '2') { // Super Admin
            return redirect()->route('admin.dashboard')->with('status', 'Welcome to Super Admin Dashboard');
        } else { // Regular User
            return redirect()->route('home')->with('status', 'You are logged in as a regular user');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
