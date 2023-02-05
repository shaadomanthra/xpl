<?php

namespace PacketPrep\Http\Controllers\Auth;

use PacketPrep\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use PacketPrep\Models\User\user_details;
use PacketPrep\Models\Product\Test;
use PacketPrep\Models\Exam\Tests_Overall;
use PacketPrep\Models\Exam\Tests_Section;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Cache;

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
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);

        Session::put('preUrl', URL::previous());

    }


    public function redirectTo()
    {
        return Session::get('preUrl') ? Session::get('preUrl') :   $this->redirectTo;
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

        if($_SERVER['HTTP_HOST'] == 'xp.test')
            return [
                $field => $request->get($this->username()),
                'password' => $request->password
            ];
            
        else

        return [
                $field => $request->get($this->username()),
                'password' => $request->password,
                'client_slug' =>$request->client_slug
            ];
            
        // if($request->client_slug){
        //         return [
        //         $field => $request->get($this->username()),
        //         'password' => $request->password,
        //         'client_slug' =>$request->client_slug
        //     ];
        // }else{
        //     return [
        //     $field => $request->get($this->username()),
        //     'password' => $request->password
        //     ];
        // }

        
    }

    public function forgotPassword(){
        return view('auth.forgot');

    }


    public function changePassword(){
        
        return view('auth.change');

    }

    public function sendPassword(Request $request){
        if(strlen($request->get('phone'))<10){
            flash('Phone number invalid (less than 10 digits)')->success();
            return redirect()->back()->withInput();
        }

        $user_details = User_Details::where('phone',$request->get('phone'))->first();
        $user = $user_details->user;
        
        if($user){
            if(strlen($user->activation_token)<7){
                $password = $user->activation_token;
                $user->send_sms($request->get('phone'),$password);
                flash('Successfully sent sms to the given phone number.')->success();
                return redirect()->back();
            }else{
                flash('This account doesnot have auto-generated password.Kindly reset password using email.')->success();
                return redirect()->back()->withInput();
            }
            
        }else{
            flash('User not found with the given phone number')->success();
            return redirect()->back()->withInput();
        }
        
    }

    public function hasSubdomain($url) {
        $parsed = parse_url($url);
        $exploded = explode('.', $parsed["host"]);
        return (count($exploded) > 2);
    }

    public function authenticated(Request $request, $user)
    {
        // if($_SERVER['HTTP_HOST'] == 'xp.test' || $_SERVER['HTTP_HOST'] == 'xplore.co.in' ){

        // }else{
        //     if(subdomain()){
        //        if($user->role!=2)
        //         if($user->client_slug!=subdomain())
        //         {
        //             auth()->logout();
        //             return back()->with('warning', 'You are not authorized to login to this website.');
        //         } 
        //     }
        // }
        
        
        $user->updated_at = date('Y-m-d H:i:s');
        $user->save();
        
        if($user->role==2)
            return redirect()->intended($this->redirectPath());
        
        // if (!$user->status) {
        //     auth()->logout();
        //     return back()->with('warning', 'Account activation required - We have sent activation link to your email. It may take 2 to 5mins for the mail to reach your inbox. Kindly check the SPAM FOLDER also. ');
        // }


        
        if ($user->status==2) {
            auth()->logout();
            return back()->with('warning', 'Your account is in blocked state. Kindly contact administrator for the access.');
        }

        if ($user->status==3) {
            auth()->logout();
            return back()->with('warning', 'Your account is in frozen state. Kindly contact administrator for the access.');
        }

        if($user->username == 'demo500' || $user->email=='demo500@gmail.com'){

           $tests = Tests_Overall::where('user_id',$user->id)->get();
           foreach($tests as $test){
                Cache::forget('attempt_'.$user->id.'_'.$test->id);
           }
           Test::where('user_id',$user->id)->delete();
           Tests_Section::where('user_id',$user->id)->delete();
           Tests_Overall::where('user_id',$user->id)->delete();
           Cache::forget('attempts_'.$user->id);
           Cache::forget('mytests_'.$user->id);
           Cache::forget('myproducts_'.$user->id);
           
        
        }
        
        
        if(session()->has('redirect.url')) {
            
             return redirect( session()->get( 'redirect.url' ) );
        }

        return redirect()->intended($this->redirectPath());
    }



}
