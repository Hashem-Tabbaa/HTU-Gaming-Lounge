<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{

    public function index()
    {
        if (Gate::allows('user') || Gate::allows('admin'))
            return redirect('/arena');

        if (Gate::allows('notverified'))
            return redirect('/verifyemail');

        return view('register');
    }

    public function register(Request $request)
    {

        if (Gate::allows('user') || Gate::allows('admin'))
            return redirect('/arena');

        if (Gate::allows('notverified'))
            return redirect('/verifyemail');

        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return $validator->errors()->first();
        }

        $otp = rand(100000, 999999);

        try {
            Mail::to($request->email)->send(new \App\Mail\VerificationEmail($otp, $request->fname, $request->lname));

            $user = new User();
            $user->uni_id = $request->uni_id;
            $user->fname = $request->fname;
            $user->lname = $request->lname;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->otp = $otp;
            $user->save();
            auth()->login($user);
        } catch (\Exception $e) {
            return 'Something went wrong, please try again later';
        }

        // redirect the user to verifyemail page with success message and the otp
        return 'success';
    }

    protected function validator($data)
    {
        $messages = [
            'uni_id.required' => 'The university ID is required',
            'fname.required' => 'The first name is required',
            'lname.required' => 'The last name is required',
            'email.required' => 'The email is required',
            'email.unique' => 'The email is already taken',
            'email.email' => 'The email must be a valid email address',
            'password.required' => 'The password is required',
            'password.min' => 'The password must be at least 8 characters',
            'password.max' => 'The password must be at most 20 characters',
            'email.regex' => 'The email must be valid HTU email',
            'confirmpassword.required' => 'The confirm password is required',
            'confirmpassword.same' => 'The confirm password must be the same as the password',
        ];

        $regex = '/^[a-zA-Z0-9._-]+@htu.edu.jo$/i';
        return Validator::make($data, [
            'uni_id' => ['required', 'string', 'max:255'],
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'regex:' . $regex],
            'password' => ['required', 'string', 'min:8', 'max:20'],
            'confirmpassword' => ['required', 'same:password'],
        ], $messages);
    }
}
