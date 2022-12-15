@extends('layouts.layout')
@section('content')
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Students</th>
                <th scope="col">Game Name</th>
                <th scope="col">Reservation Time</th>
            </tr>
        </thead>
        <tbody>
        @foreach($reservations as $reservation)
                <tr>
                    <td>
                        {{$reservation->student1_email}}
                        {{$reservation->student2_email}}
                        {{$reservation->student3_email}}
                        {{$reservation->student4_email}}
                    </td>
                    <td>{{$reservation->game_name}}</td>
                    <td>{{$reservation->res_time}}</td>
                </tr>
        @endforeach
@endsection
