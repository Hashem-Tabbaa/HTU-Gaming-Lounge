@extends('layouts.layout')

@section('content')

<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100 p-0 pt-5 pb-5">
            <form class="login100-form validate-form" method="post" action="/register">
                @csrf
                <span class="login100-form-title p-b-48">
                    <img src="./images/HTU Logo-250px.png" alt="">
                </span>

                <span class="login100-form-title m-5">
                    Sign Up
                </span>

                  <div class="d-flex justify-content-around">
                    <div class="wrap-input100 validate-input" style="width: fit-content">
                        <label class="m-auto" data-placeholder="First Name">Firat Name</label>
                        <input required class="input100" type="text" name="fname">
                    </div>

                    <div class="wrap-input100 validate-input">
                        <label class="" data-placeholder="Last Name">Last Name</label>
                        <input required class="input100" type="text" name="lname">
                    </div>

                </div>

                <div class="d-flex justify-content-around">
                    <div class="wrap-input100 validate-input" data-validate = "Valid email is: a@htu.edu.jo">
                        <label class="" data-placeholder="Email">Email</label>
                        <input required class="input100" type="text" name="email">
                    </div>
                    <div class="wrap-input100 validate-input">
                        <label class="" data-placeholder="University ID">University ID</label>
                        <input required class="input100" type="number" name="uni_id">
                    </div>
                </div>

                <div class="d-flex justify-content-around">
                    <div class="wrap-input100 validate-input" data-validate="Enter password">
                        <label class="" data-placeholder="Password">Password</label>
                        <input required class="input100" type="password" name="password">
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Enter password">
                        <label class="" data-placeholder="Confirm Password">Confirm Password</label>
                        <input required class="input100" type="password" name="confirm_password">
                    </div>
                </div>

                @if ($errors->any())
                    <p class="text-danger m-auto" style="width: fit-content">{{ $errors->first() }}</p>
                @endif

                <div class="container-login100-form-btn w-50 m-auto">
                    <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn"></div>
                        <button class="login100-form-btn">
                            Sign Up
                        </button>
                    </div>
                </div>

                <hr class="w-100" style="margin-top: 20px; margin-bottom: 20px; border: 1px dotted black;">

                <div class="text-center">
                    <span class="txt4">
                        Have an account?
                    </span>
                    <a class="txt3 link-danger" href="/login" style="font-size: 1.1em">
                        Log in
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
