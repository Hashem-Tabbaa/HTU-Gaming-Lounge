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
                        <li>
                            <ul>{{$reservation->student1_email}}</ul>
                            <ul>{{$reservation->student2_email}}</ul>
                            <ul>{{$reservation->student3_email}}</ul>
                            <ul>{{$reservation->student4_email}}</ul>
                        </li>
                    </td>
                    <td>{{$reservation->game_name}}</td>
                    <td>{{$reservation->res_time}}</td>
                </tr>
        @endforeach
@endsection
