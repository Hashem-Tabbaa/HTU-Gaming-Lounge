@extends('layouts.layout')
@section('content')
    <table class="table table-striped">
        <thead>
            <tr>
                {{-- <th scope="col">Students</th> --}}
                <th scope="col">Game Name</th>
                <th scope="col">Starts</th>
                <th scope="col">Ends</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($myreservations as $reservation)
                <tr class="{{ $reservation->game_name }}" id="res{{ $reservation->id }}">
                    <td>{{ $reservation->game_name }}</td>
                    <td>{{ $reservation->res_time }}</td>
                    <td>{{ $reservation->res_end_time }}</td>
                    <td class="text-center d-flex flex-wrap justify-content-center gap-3">
                        <form action="/myreservations/cancel" method="POST" class="form">
                            @csrf
                            <input type="number " name="id" value="{{ $reservation->id }}" hidden>
                            <button type="submit" class="btn btn-danger">Cancel</button>
                        </form>
                        <div class="dropdown">
                            <button class="btn btn-secondary btn" id="dropdownMenuButton" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-caret-down" aria-hidden="true"></i>
                                Players
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                <ul class="p-0">{{ $reservation->student1_email }}</ul>
                                <ul class="p-0">{{ $reservation->student2_email }}</ul>
                                <ul class="p-0">{{ $reservation->student3_email }}</ul>
                                <ul class="p-0">{{ $reservation->student4_email }}</ul>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <script>
            $(document).ready(function() {
                $('.form').submit(function(e) {
                    e.preventDefault();
                    let form = $(this);
                    swal({
                        title: "Are you sure?",
                        text: "Once canceled, you will not be able to recover this reservation!",
                        icon: "warning",
                        buttons: true,
                    }).then(function(isConfirm) {
                        if (isConfirm) {
                            $('#loader').show();
                            $.ajax({
                                type: form.attr('method'),
                                url: form.attr('action'),
                                data: form.serialize(),
                                success: function(data) {
                                    $('#loader').hide();
                                    if (isNaN(data)) {
                                        swal({
                                            icon: "error",
                                            title: "Cancelation Failed",
                                            text: data,
                                            showConfirmButton: true,
                                        })
                                    }

                                    var id = data;
                                    var row = document.querySelector('#res' + id);
                                    row.hidden = true;
                                }
                            });
                        }
                    })
                });
            });
        </script>
    @endsection
