<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
class VerifyEmailController extends Controller{

    public function index(){
        if(Gate::denies('notverified'))
            return redirect('/arena');

        return view('verifyemail');
    }

    public function verify(Request $request){
        if(Gate::denies('notverified'))
            return redirect('/arena');

        $user = User::where('otp', $request->otp)->first();
        if($user){
            $user->otp = null;
            $user->email_verified_at = now();
            $user->verified = 1;
            $user->save();
            auth()->login($user);
            return redirect('/arena');
        }
        return redirect('/verifyemail')->withErrors('Wrong code, please try again')->withInput();
    }

    public function resendotp(){

        $email = auth()->user()->email;
        if ($email == null)
            return redirect('/index');
        $otp = rand(100000, 999999);
        $fname = auth()->user()->fname;
        $lname = auth()->user()->lname;
        User::where('email', $email)->update(['otp' => $otp]);

        try{
            Mail::send('email', ['otp' => $otp, 'fname' => $fname, 'lname' => $lname],
                function($message) use ($email) {
                    $message->to($email, 'HTU Arena')->subject('HTU Arena - Verify your email');
                    $message->from('htugaminglounge@gmail.com','HTU Arena');
                });
        }catch(\Exception $e){
            return redirect('/verifyemail')->withError('Something went wrong, please try again later')->withInput();
        }

        return redirect('/verifyemail')->with('success', 'A verification code has been sent to your email, please enter it below');
    }
}
