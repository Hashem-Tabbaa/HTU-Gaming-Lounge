@extends('layouts.layout')
@section('content')
<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
                <span class="login100-form-title p-b-48">
                    <img src="./images/HTU Logo-250px.png" alt="">
                </span>

                <span class="login100-form-title p-b-26">
                    Email Verification
                </span>
                <span>
                    A code has been sent to your email. Please enter it below to verify your email.
                </span>
                <form action="/verifyemail" method="post">
                    @csrf
                    <div class="wrap-input100 validate-input mt-3">
                        <label for="" class="text-secondary">Verification Code</label>
                        <input class="input100" placeholder="XXXXXX" type="text" name="otp" required>
                    </div>
                    @if ($errors->any())
                        <p class="text-danger m-auto" style="width: fit-content">{{ $errors->first() }}</p>
                    @endif
                    <div class="d-flex justify-content-around">
                        <button class="btn btn-primary" type="submit">
                            Verify
                        </button>
                        <a href="/resendotp" class="btn btn-primary">Resend a verification code</a>
                    </div>
                </form>
        </div>
    </div>
</div>

@if (Session::has('success'))
    <script>
        swal({
            icon: "success",
            title: "Email Verification",
            text: "A code has been sent to your email.",
            showConfirmButton: true,
        });
    </script>
@endif

@endsection
