<?php

namespace PacketPrep\Http\Controllers\Auth;

use PacketPrep\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

     /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $field = filter_var($request->get($this->username()), FILTER_VALIDATE_EMAIL)
            ? $this->username()
            : 'username';

        return [
            $field => $request->get($this->username()),
            'password' => $request->password,
        ];
    }


    public function authenticated(Request $request, $user)
    {
        if (!$user->status) {
            auth()->logout();
            return back()->with('warning', 'Kindly contact the website adminstrator to activate your account.');
        }

        if ($user->status==2) {
            auth()->logout();
            return back()->with('warning', 'Your account is in blocked state. Kindly contact administrator for the access.');
        }

        if ($user->status==3) {
            auth()->logout();
            return back()->with('warning', 'Your account is in frozen state. Kindly contact administrator for the access.');
        }
        return redirect()->intended($this->redirectPath());
    }

}
