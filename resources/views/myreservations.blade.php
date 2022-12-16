@extends('layouts.layout')
@section('content')
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Students</th>
                <th scope="col">Game Name</th>
                <th scope="col">Starts</th>
                <th scope="col">Ends</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($myreservations as $reservation)
                <tr class="{{ $reservation->game_name }}" id="res{{ $reservation->id }}">
                    <td>
                        <li>
                            <ul>{{ $reservation->student1_email }}</ul>
                            <ul>{{ $reservation->student2_email }}</ul>
                            <ul>{{ $reservation->student3_email }}</ul>
                            <ul>{{ $reservation->student4_email }}</ul>
                        </li>
                    </td>
                    <td>{{ $reservation->game_name }}</td>
                    <td>{{ $reservation->res_time }}</td>
                    <td>{{ $reservation->res_end_time }}</td>
                    <td class="text-center">
                        <form action="/myreservations/cancel" method="POST" class="form">
                            @csrf
                            <input type="number " name="id" value="{{ $reservation->id }}" hidden>
                            <button type="submit" class="btn btn-danger">Cancel</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            <script>
                $(document).ready(function() {
                    $('.form').submit(function(e) {
                        e.preventDefault();
                        var form = $(this);
                        $.ajax({
                            type: form.attr('method'),
                            url: form.attr('action'),
                            data: form.serialize(),
                            success: function(data) {
                                if(isNaN(data)){
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
                    });
                });
            </script>
        @endsection
