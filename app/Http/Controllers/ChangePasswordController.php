<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller{

    public function index(){
        if( Gate::denies('user') && Gate::denies('admin') )
            return redirect('/login');

        if(Gate::allows('notverified'))
            return redirect('/verifyemail');

        return view('changepassword');
    }

    public function changePassword(Request $request){

        if( Gate::denies('user') && Gate::denies('admin') )
            return redirect('/login');

        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return redirect('/changepassword')
                        ->withErrors($validator->errors())
                        ->withInput();
        }

        $user = auth()->user();
        $oldpassword = $request->oldpassword;
        $newpassword = $request->newpassword;

        if( !Hash::check($oldpassword, $user->password) )
            return redirect('/changepassword')->withErrors('Your old password is incorrect')->withInput();

        $user->password = Hash::make($newpassword);
        $user->save();
        return redirect('/arena')->with('success', 'Your password has been changed');
    }
    private function validator($data){
        $messages = [
            'oldpassword.required' => 'Please enter your old password',
            'newpassword.required' => 'Please enter your new password',
            'newpassword.min' => 'Your new password must be at least 8 characters',
            'confirmpassword.required' => 'Please confirm your new password',
            'confirmpassword.same' => 'Your new password and confirmation password do not match'
        ];
        return Validator::make($data, [
            'oldpassword' => 'required',
            'newpassword' => 'required|min:8',
            'confirmpassword' => 'required|same:newpassword'
        ], $messages);
    }

}
