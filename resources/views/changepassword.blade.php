@extends('layouts.layout')
@section('content')

<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100 p-0 pt-5 pb-5">
            <span class="login100-form-title p-b-48">
                <img src="./images/HTU Logo-250px.png" alt="">
            </span>

            <span class="login100-form-title mb-5">
                Change Password
            </span>
            <form class="login100-form validate-form" method="post" action="/changepassword">
                @csrf
                <div class="wrap-input100 validate-input m-auto">
                    <label class="m-auto">Old Password</label>
                    <input class="input100" type="password" name="oldpassword" required autocomplete="current-password">
                </div>
                <div class="d-flex flex-wrap justify-content-lg-between">

                    <div class="wrap-input100 validate-input m-auto mt-5 mb-5" data-validate="Enter password">
                        <label class="m-auto">New Password</label>
                        <input class="input100" type="password" name="newpassword" required>
                    </div>
                    <div class="wrap-input100 validate-input m-auto mb-5" data-validate="Enter password">
                        <label class="m-auto">Confirm New Password</label>
                        <input class="input100" type="password" name="confirmpassword" required>
                    </div>
                </div>

                @if ($errors->any())
                    <p class="text-danger m-auto" style="width: fit-content">{{ $errors->first() }}</p>
                @endif

                <div class="container-login100-form-btn mt-3 w-50 m-auto">
                    <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn"></div>
                        <button class="login100-form-btn">
                            Change Password
                        </button>
                    </div>
                </div>

                <hr class="w-100" style=" border: 1px dotted black;">
            </form>
        </div>
    </div>
</div>

@endsection
