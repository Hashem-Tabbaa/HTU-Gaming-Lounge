<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use \UxWeb\SweetAlert\SweetAlert;

class RegisterController extends Controller{

    public function index(){
        if( Gate::allows('user') ||Gate::allows('admin'))
            return redirect('/arena');

        return view('register');
    }

    public function register(Request $request){

        if( Gate::allows('user') || Gate::allows('admin'))
            return redirect('/arena');

        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return redirect('/register')
                        ->withErrors($validator)
                        ->withInput();
        }

        $otp = rand(100000, 999999);

        try{
            Mail::send('email', ['otp' => $otp, 'fname' => $request->fname, 'lname' => $request->lname],
                    function($message) use ($request) {
                        $message->to($request->email, 'HTU Arena')->subject('HTU Arena - Verify your email');
                        $message->from('htugaminglounge@gmail.com','HTU Arena');
            });
        }catch(\Exception $e){
            return redirect('/register')->withError('Something went wrong, please try again later')->withInput();
        }

        $user = new User();

        $user->uni_id = $request->uni_id;
        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->otp = $otp;

        $user->save();

        // SweetAlert::success('Success', 'A verification code has been sent to your email, please enter it below');

        auth()->login($user);

        // redirect the user to verifyemail page with success message and the otp
        return redirect('/verifyemail')->with('success', 'A verification code has been sent to your email, please enter it below');
    }

    protected function validator($data){
        $messages = [
            'uni_id.required' => 'The university ID is required',
            'uni_id.unique' => 'The university ID is already taken',
            'fname.required' => 'The first name is required',
            'lname.required' => 'The last name is required',
            'email.required' => 'The email is required',
            'email.unique' => 'The email is already taken',
            'email.email' => 'The email must be a valid email address',
            'password.required' => 'The password is required',
            'password.min' => 'The password must be at least 8 characters',
            'password.max' => 'The password must be at most 20 characters',
            'email.regex' => 'The email must be valid HTU email',
        ];

        $regex = '/^[a-zA-Z0-9._-]+@htu.edu.jo$/';
        return Validator::make($data, [
            'uni_id' => ['required', 'string', 'max:255'],
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'regex:'.$regex],
            'password' => ['required', 'string', 'min:8', 'max:20'],
        ], $messages);
    }
}
