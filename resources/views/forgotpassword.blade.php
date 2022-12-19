@extends('layouts.layout')
@section('content')
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100 p-0 pt-5 pb-5">
                <span class="login100-form-title p-b-48">
                    <img src="./images/HTU Logo-250px.png" alt="">
                </span>

                <span class="login100-form-title mb-5">
                    HTU Gaming Lounge
                </span>
                <form class="login100-form validate-form form" method="post" action="/forgot-password">
                    @csrf
                    <div class="d-flex flex-wrap">
                        <div class="wrap-input100 validate-input m-auto" data-validate="Valid email is: a@b.c">
                            <label class="m-auto" data-placeholder="Email">Email</label>
                            <input class="input100" type="text" name="email" required>
                        </div>
                    </div>

                    <p class="text-danger m-auto" style="width: fit-content" id="error_message"></p>

                    <div class="container-login100-form-btn mt-3 w-25 m-auto">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button class="login100-form-btn">
                                Reset Password
                            </button>
                        </div>
                    </div>

                    <hr class="w-100" style="margin-top: 20px; margin-bottom: 20px; border: 1px dotted black;">

                    <div class="text-center">
                        <span class="txt4">
                            Have an account?
                        </span>
                        <a class="txt3 link-danger" href="/register" style="font-size: 1.1em">
                            Sign up
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
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
                        if (response.success) {
                            console.log(response.success);
                            swal({
                                icon: "success",
                                title: "Forgot Password",
                                text: response.success,
                                showConfirmButton: true,
                            });
                        }else{
                            $('#error_message').html(response.error);
                        }
                    }
                });
            });
        });
    </script>
@endsection
