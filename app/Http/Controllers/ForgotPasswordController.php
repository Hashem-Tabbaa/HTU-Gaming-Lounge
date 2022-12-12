<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class ForgotPasswordController extends Controller{


    public function index(){
        if( Gate::allows('user') || Gate::allows('admin') || Gate::allows('notverified') ){
            return redirect('/index');
        }
        return view('forgotpassword');
    }

    public function sendotp(Request $request)
    {
        if (Gate::allows('user') || Gate::allows('admin') || Gate::allows('notverified')) {
            return redirect('/index');
        }
        $email = $request->email;
        $user = User::where('email', $email)->first();
        if ($user) {
            $otp = rand(100000, 999999);
            $fname = $user->fname;
            $lname = $user->lname;
            User::where('email', $email)->update(['otp' => $otp]);
            try {
                Mail::send(
                    'email',
                    ['otp' => $otp, 'fname' => $fname, 'lname' => $lname],
                    function ($message) use ($email) {
                        $message->to($email, 'HTU Arena')->subject('HTU Arena - Verify your email');
                        $message->from('htugaminglounge@gmail.com', 'HTU Arena');
                    }
                );
            } catch (\Exception $e) {
                return redirect('/forgotpassword')->withErrors('Something went wrong, please try again later')->withInput();
            }
            return redirect('/verifyotp')->with('success', 'A verification code has been sent to your email, please enter it below');
        }
        return redirect('/forgotpassword')->withErrors('Email not found, please try again')->withInput();
    }

    public function verifyotp(Request $request)
    {
        if (Gate::allows('user') || Gate::allows('admin') || Gate::allows('notverified')) {
            return redirect('/index');
        }
        $otp = $request->otp;
        $user = User::where('otp', $otp)->first();
        if ($user) {
            $user->otp = null;
            $user->save();
            return redirect('/resetpassword');
        }
        return redirect('/verifyotp')->withErrors('Wrong code, please try again')->withInput();
    }
}
