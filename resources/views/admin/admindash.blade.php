@extends('layouts.layout')
@section('content')

    {{-- dropdown list to select the game to be shown --}}

    <select id="game" class="m-auto form-select" style="width: fit-content;">
        <option value="All">All</option>
        <option value="PS5">PS5</option>
        <option value="Billiard">Billiard</option>
        <option value="Ping-Pong">Ping-Pong</option>
        <option value="Air-Hockey">Air-Hockey</option>
        <option value="Baby-Football">Baby-Football</option>
    </select>

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
                <tr class="{{$reservation->game_name}}" id="record">
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
                    <td class="text-center">
                        <form action="/admin/removeReservation" method="POST">
                            @csrf
                            <input type="number " name="id" value="{{$reservation->id}}" hidden>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
        @endforeach
        <script>
            document.querySelector('#game').addEventListener('change', function(e) {
                var game = e.target.value;
                var rows = document.querySelectorAll('#record');
                if (game == 'All') {
                    for (var i = 0; i < rows.length; i++)
                        rows[i].style.display = 'table-row';
                    return;
                }
                for (var i = 0; i < rows.length; i++) {
                    if (rows[i].classList.contains(game)) {
                        rows[i].style.display = 'table-row';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            });
        </script>
@endsection
