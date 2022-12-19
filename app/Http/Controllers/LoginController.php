<?php

namespace App\Http\Controllers;

use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
class LoginController extends Controller{

    public function index(){

        if( Gate::allows('user') || Gate::allows('admin'))
            return redirect('/arena');

        if(Gate::allows('notverified'))
            return redirect('/verifyemail');

        return view('login');
    }

    public function login(Request $request){

        if( Gate::allows('user') || Gate::allows('admin'))
            return redirect('/arena');

        if(Gate::allows('notverified'))
            return redirect('/verifyemail');

        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return $validator->errors()->first();
        }

        $credentials = $request->only('email', 'password');

        if(auth()->attempt($credentials)){
            if(auth()->user()->role == 'admin')
                return redirect('/admin');
            return 'success';
        }

        return 'Invalid email or password';
    }
    public function logout(){
        auth()->logout();
        return redirect('/login');
    }

    protected function validator($data){

        $messages = [
            'email.required' => 'Email is required',
            'email.email' => 'Invalid email',
            'password.required' => 'Password is required',
        ];
        return Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required',
        ], $messages);
    }
}
