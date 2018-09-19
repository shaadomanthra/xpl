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

    public function hasSubdomain($url) {
        $parsed = parse_url($url);
        $exploded = explode('.', $parsed["host"]);
        return (count($exploded) > 2);
    }

    public function authenticated(Request $request, $user)
    {

        if($user->role==2)
            return redirect()->intended($this->redirectPath());
        $url = url()->full();
        if($this->hasSubdomain($url)){
            $parsed = parse_url($url);
            $exploded = explode('.', $parsed["host"]);
            $subdomain = $exploded[0];
        }else
            $subdomain = null;

        if (!$user->status) {
            auth()->logout();
            return back()->with('warning', 'Kindly contact the website adminstrator to activate your account.');
        }

        if($subdomain != 'corporate'){
            if($user->client_slug != 'corporate')
            if ($user->client_slug != $subdomain) {
                auth()->logout();
                return back()->with('warning', 'You dont have access to this website. Kindly Contact the website administrator');
            }
        }else{
            if(!$user->checkRole(['administrator','manager','investor','patron','promoter','employee','marketing-manager','marketing-executive','client-owner','client-manager']))
               auth()->logout();
                return back()->with('warning', 'You dont have access to this website. Kindly Contact the website administrator'); 
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
