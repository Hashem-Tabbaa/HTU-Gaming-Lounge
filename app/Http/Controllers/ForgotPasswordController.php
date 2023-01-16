<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{


    public function index()
    {
        if (Gate::allows('user') || Gate::allows('admin') || Gate::allows('notverified')) {
            return redirect('/index');
        }
        return view('forgotpassword');
    }

    public function sendPasswordResetEmail(Request $request){

        // Validate the form data

        $messages = [
            'email.required' => 'Email is required',
            'email.email' => 'Email is invalid',
        ];

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ], $messages);

        if($validator->fails()){
            return ['error' => $validator->errors()->first()];
        }

        // Get the user with the provided email
        $user = User::where('email', $request->email)->first();

        // If the user doesn't exist, redirect back with an error message
        if (!$user) {
            return ['error' => 'We couldn\'t find a user with that email address.'];
        }

        // Generate a password reset token for the user
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $token = substr(str_shuffle(str_repeat($pool, 1)), 0, 60);


        // Send the password reset email to the user
        try {
            User::where('email', $request->email)->update(['password_reset_token' => $token]);
            Mail::to($request->email)->send(new \App\Mail\ForgotPassword($token, $request->fname, $request->lname));
        } catch (\Exception $e) {
            return ['error' => 'Something went wrong. Please try again later.'];
        }

        // Redirect back with a success message
        return ['success' => 'A password reset link has been sent to your email address.'];
    }

    public function getResetPasswordPage($token){
        $user = User::where('password_reset_token', $token)->get();

        if(count($user) > 0){
            return view('resetpassword', ['token' => $token]);
        }else{
            return redirect('/arena')->withErrors(['email' => 'The password reset link is invalid or has expired.']);
        }
    }

    public function resetPassword(Request $request){
        // Validate the form data

        $messages = [
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
            'password.confirmed' => 'Passwords do not match',
            'password_confirmation.required' => 'Password confirmation is required',
        ];

        $request->validate([
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
        ], $messages);

        // Get the user with the provided email
        $user = User::where('password_reset_token', $request->token)->first();

        // If the user doesn't exist, redirect back with an error message
        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'We couldn\'t find a user with that email address.']);
        }

        // Update the user's password
        $user->password = bcrypt($request->password);
        $user->password_reset_token = null;
        $user->save();

        // Redirect back with a success message
        return redirect('/login')->with('success', 'Your password has been reset successfully. Please login with your new password.');
    }
}
