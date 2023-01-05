@extends('layouts.layout')

@section('content')
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100 p-0 pt-5 pb-5">
                <form class="login100-form validate-form form" method="post" action="/register">
                    @csrf
                    <span class="login100-form-title mb-5">
                        <img src="./images/HTU Logo-250px.png" alt="" class="login-img">
                    </span>

                    <span class="login100-form-title">
                        Sign Up
                    </span>

                    <div class="p-5">
                        <div class="d-flex justify-content-around login">
                            <div class="wrap-input100 validate-input" style="width: fit-content; margin-right:10px;">
                                <label class="m-auto" data-placeholder="First Name">First Name</label>
                                <input required class="input100" type="text" name="fname">
                            </div>

                            <div class="wrap-input100 validate-input left">
                                <label class="" data-placeholder="Last Name">Last Name</label>
                                <input required class="input100" type="text" name="lname">
                            </div>
                        </div>

                        <div class="d-flex justify-content-around">
                            <div class="wrap-input100 validate-input" style="margin-right:10px;"
                                data-validate="Valid email is: a@htu.edu.jo">
                                <label class="" data-placeholder="Email">Email</label>
                                <input required class="input100" type="text" name="email">
                            </div>
                            <div class="wrap-input100 validate-input">
                                <label class="" data-placeholder="University ID">University ID</label>
                                <input required class="input100" type="number" name="uni_id">
                            </div>
                        </div>

                        <div class="d-flex justify-content-around">
                            <div class="wrap-input100 validate-input" style="margin-right:10px;"
                                data-validate="Enter password">
                                <label class="" data-placeholder="Password">Password</label>
                                <input required class="input100" type="password" name="password">
                            </div>
                            <div class="wrap-input100 validate-input" data-validate="Enter password">
                                <label class="" data-placeholder="Confirm Password">Confirm Password</label>
                                <input required class="input100" type="password" name="confirmpassword">
                            </div>
                        </div>

                        <p class="text-danger m-auto" id="error_message" style="width: fit-content"></p>

                        <div class="container-login100-form-btn w-50 m-auto">
                            <div class="wrap-login100-form-btn">
                                <div class="login100-form-bgbtn"></div>
                                <button class="login100-form-btn">
                                    Sign Up
                                </button>
                            </div>
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

    <script>
        $(document).ready(function() {
            console.log('ready');
            $('.form').submit(function(e) {
                $('#loader').show();
                e.preventDefault();
                var form = $(this);
                var data = form.serialize();
                var url = form.attr('action');
                var method = form.attr('method');
                $.ajax({
                    type: method,
                    url: url,
                    data: data,
                    success: function(response) {
                        $('#loader').hide();
                        console.log(response);
                        if (response == 'success') {
                            window.location.href = '/verifyemail';
                        } else
                            document.getElementById('error_message').innerHTML = response;
                    }
                });
            });
        });
    </script>
@endsection
