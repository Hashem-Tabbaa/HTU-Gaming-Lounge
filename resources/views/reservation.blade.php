@extends('layouts.layout')
@section('content')
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <span class="login100-form-title p-b-48">
                    <?php $image_path = '/images/' . $game->name . '.gif'; ?>
                    <img src={{ $image_path }} alt="" width="auto" height="125">
                </span>

                <span class="login100-form-title p-b-26" id="reservation-title">
                    {{ $game->name }} ( {{ $game->session_duration }} min)
                </span>
                <p class="text-primary m-auto mb-4" style="width: fit-content;"> *You are the first player </p>
                <form method="post" action="/reserve" class="form">
                    @csrf
                    <div class="validate-input" data-validate="Valid email is: a@htu.edu.jo">
                        <div class="align-items-center d-flex justify-content-lg-between flex-wrap">
                            <div class="p-3 m-auto">
                                <div class="d-flex form-switch">
                                    <input class="form-check-input" type="checkbox" id="secondPlayer" name="2"
                                        value="1" checked>
                                    <label style="margin-left: 15px"class="" for="secondPlayer">Second Player</label>
                                </div>
                                <input class="form-control" type="text" name="email2" placeholder="HTU Email"
                                    id="email2" required>
                            </div>
                            <div class="p-3 m-auto">
                                <div class="d-flex form-switch">
                                    <input class="form-check-input" type="checkbox" id="thirdPlayer" name="3"
                                        value="1" checked>
                                    <label style="margin-left: 15px" for="thirdPlayer">Third Player</label>
                                </div>
                                <input class="form-control" type="text" name="email3" placeholder="HTU Email"
                                    id="email3" required>
                            </div>
                            <div class="p-3 m-auto">
                                <div class="d-flex form-switch">
                                    <input class="form-check-input " type="checkbox" id="fourthPlayer" name="4"
                                        value="1" checked>
                                    <label style="margin-left: 15px"class="" for="fourthPlayer">Fourth Player</label>
                                </div>
                                <input class="form-control" type="text" name="email4" placeholder="HTU Email"
                                    id="email4" required>
                            </div>
                        </div>
                    </div>
                    <div class="m-auto mt-3 mb-3" style="width: fit-content;">
                        <label style="margin-left: 15px"class="" for="time_slots" class="m-auto">Reservation
                            Time</label>
                        <select name="time_slot" id="time_slots" class="form-select form-select-lg" required>
                            @foreach ($timeSlots as $timeSlot)
                                <option value={{ $timeSlot }}>{{ $timeSlot }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="text" value="{{ $game->name }}" name="game" hidden>
                    <div class="container-login100-form-btn">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button class="login100-form-btn" value="Submit" type="submit">
                                Reserve
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        //disable the email input if the checkbox is not checked
        document.querySelectorAll(".form-check-input").forEach((item) => {
            item.addEventListener("change", (event) => {
                var input = document.getElementById("email" + event.target.name);
                if (event.target.checked) {
                    input.disabled = false;
                    input.required = true;
                } else {
                    input.disabled = true;
                    input.value = "";
                    input.required = false;
                }
            })
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.form').submit(function(e) {
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
                        console.log(response);
                        if(response.success){
                            swal({
                                icon: "success",
                                title: "Reservation Success",
                                text: response.success,
                                showConfirmButton: true,
                            });
                        }
                        else{
                            swal({
                                icon: "error",
                                title: "Reservation Failed",
                                text: response.error,
                                showConfirmButton: true,
                            });
                        }
                    }
                });
            });
        });
    </script>
    @if (Session::has('error'))
        <script>
            swal({
                icon: "error",
                title: "Reservation Failed",
                text: "{{ Session::get('error') }}",
                showConfirmButton: true,
            });
        </script>
    @elseif (Session::has('success'))
        <script>
            swal({
                icon: "success",
                title: "Reservation Success",
                text: "{{ Session::get('success') }}",
                showConfirmButton: true,
            });
        </script>
    @endif
@endsection
