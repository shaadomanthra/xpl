<?php

namespace PacketPrep\Http\Controllers\User;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\User;
use Illuminate\Support\Facades\Mail;
use PacketPrep\Mail\ActivateUser2;
use Illuminate\Support\Facades\Cache;

class VerifyController extends Controller
{
    /**
     * Verify Email
     *
     * @return \Illuminate\Http\Response
     */
    public function activation(Request $request)
    {
    	$user = \auth::user();


    	/* update phone number */
    	if($request->get('type')=='update_phone'){
    		$phone = $request->get('number');
    		$user_exists = User::where('phone',$phone)->first();
    		if(!$user_exists){
    			$user->phone = $phone;
    			$user->save();
    			$message = 'User phone number successfully updated to '.$phone;
    			flash($message)->success();	
    		}else{
    			$message = 'The given phone number '.$phone.' is already in use. Kindly use a different number.';
    			flash($message)->error();
    		}
    		
    	}

    	/* update email */
    	if($request->get('type')=='update_email'){
    		$email = $request->get('email');
    		$user_exists = User::where('email',$email)->first();
    		if(!$user_exists){
    			$user->email = $email;
    			$user->save();
    			$message = 'User email address successfully updated to '.$email;
    			flash($message)->success();	
    		}else{
    			$message = 'The given email address '.$email.' is already in use. Kindly use a different address.';
    			flash($message)->error();
    		}
    	}

    	/* Resend Email */
    	if($request->get('resend_email')){
    		if($user->activation_token!=1){
    			Mail::to($user->email)->send(new ActivateUser2($user));
    			$message = 'Successfully resent activation email to '.$user->email;
    			flash($message)->success();	
    		}else{
    			$message = 'Email already verified !';
    			flash($message)->warning();	
    		}
    		
    	}


    	/* Resend SMS */
    	if($request->get('resend_sms')){
    		if(!request()->session()->get('code')){
	            $code = mt_rand(1000, 9999);
	            request()->session()->put('code',$code);
	        }else{
	            $code = request()->session()->get('code');
	        }
    		$user->send_sms($user->phone,$code);
    		$message = 'Successfully resent the activation code to '.$user->phone;
    		flash($message)->success();	
    	}
        Cache::forget('id-' . $user->id);
        Cache::forget('user_'.$user->id);
    	return view('appl.user.verify.activation')
                ->with('user',$user);
    }

    public function refresh(Request $request)
    {

        $user = \auth::user();
        $message = 'User data refreshed!';
        flash($message)->warning();
        Cache::forget('id-' . $user->id);
        Cache::forget('user_'.$user->id);
        return redirect()->route('dashboard')->with('message',$message);

    }


    /**
     * Verify Email
     *
     * @return \Illuminate\Http\Response
     */
    public function email($code,Request $request)
    {
    	$activation_code = $code;
    	$email = $request->get('email');
    	if(!$email)
    		abort('403','Email not found');
    	$user = User::where('email',$email)->first();

    	if($activation_code == $user->activation_token){
    		$user->activation_token =1;
    		$user->save();
    		$message = 'Successfully verified user email';
            Cache::forget('id-' . $user->id);
    		flash($message)->success();
    	}else if($user->activation_token == 1){
    		$message = 'Email verification already completed';
    		flash($message)->warning();
    	}else{
    		$message = 'Invalid email verification code';
    		flash($message)->error();
    	}
        return view('appl.user.verify.message')
                ->with('message',$message);
    }

    /**
     * Verify Phone number
     *
     * @return \Illuminate\Http\Response
     */
    public function sms(Request $request)
    {
    	$sms_code = $request->get('sms_code');
    	$code = request()->session()->get('code');
        $api = $request->get('api');

    	if($code==$sms_code){
    		$user = \auth::user();
    		$user->status =0;
    		$user->save();
            $error=0;
    		$message = 'Successfully verified user phone number.';
            Cache::forget('id-' . $user->id);
    		flash($message)->success();
    	}else{
    		$message = 'Invalid phone verification code';
            $error =1;
    		flash($message)->error();
    	}
        if($api){
            if($error){
                $arr["error"] =1;
                $arr["message"] = $message; 
            }else{
                $arr["error"] =0;
                $arr["message"] = $message; 
            }
            return json_encode($arr);
            
        }else
            return redirect()->route('activation');

    }
}
