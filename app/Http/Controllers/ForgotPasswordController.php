<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Password;

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
        $request->validate([
            'email' => 'required|email',
        ]);

        // Get the user with the provided email
        $user = User::where('email', $request->email)->first();

        // If the user doesn't exist, redirect back with an error message
        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'We couldn\'t find a user with that email address.']);
        }

        // Generate a password reset token for the user
        // $token =

        // Send the password reset email to the user
        try {
            Mail::to($request->email)->send(new \App\Mail\forgotPassword($token, $request->fname, $request->lname));
        } catch (\Exception $e) {
            return $e;
        }


        // Redirect back with a success message
        return redirect()->back()->with('status', 'We have sent a password reset link to your email. Please check your email and follow the instructions to reset your password.');
    }
}
