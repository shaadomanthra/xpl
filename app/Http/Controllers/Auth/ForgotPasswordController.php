<?php

namespace PacketPrep\Http\Controllers\Auth;

use PacketPrep\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function sendResetLinkEmail(Request $request)
    {
            $this->validate($request, ['email' => 'required'], ['email.required' => 'Please enter your email.']);

             $response = $this->broker()->sendResetLink(
                $request->only('email','client_slug')
            );

            if ($response === Password::RESET_LINK_SENT) {
                return back()->with('status', trans($response));
            }

            return back()->withErrors(
                ['email' => trans($response)]
            );
    }

}
