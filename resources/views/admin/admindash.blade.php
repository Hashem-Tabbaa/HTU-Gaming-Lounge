@extends('layouts.layout')
@section('content')
    {{-- dropdown list to select the game to be shown --}}

    <div class="d-flex justify-content-around">
        <div>
            <label for="game">Game</label>
            <select id="game" class="m-auto form-select" style="width: fit-content;">
                <option value="All">All</option>
                <option value="PS5">PS5</option>
                <option value="Billiard">Billiard</option>
                <option value="Ping-Pong">Ping-Pong</option>
                <option value="Air-Hockey">Air-Hockey</option>
                <option value="Baby-Football">Baby-Football</option>
            </select>
        </div>
        <div>
            <label for="time">Time</label>
            <select id="time" class="m-auto form-select" style="width: fit-content;">
                <option value="All">All</option>
                <option value="Upcoming">Upcoming</option>
                <option value="Running">Running</option>
            </select>
        </div>
    </div>

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
            @foreach ($reservations as $reservation)
                <tr class="record visible {{ $reservation->game_name }}" id="{{ $reservation->game_name }}">
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
                        <form action="/admin/removeReservation" method="POST">
                            @csrf
                            <input type="number " name="id" value="{{ $reservation->id }}" hidden>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            <script>
                document.querySelector('#game').addEventListener('change', function(e) {
                    var game = e.target.value;
                    var rows = document.querySelectorAll('.record');
                    if (game == 'All') {
                        for (var i = 0; i < rows.length; i++) {
                            rows[i].style.display = 'table-row';
                            rows[i].classList.add('visible');
                        }
                        return;
                    }
                    for (var i = 0; i < rows.length; i++) {
                        if (rows[i].classList.contains(game)) {
                            rows[i].style.display = 'table-row';
                            rows[i].classList.add('visible');
                        } else {
                            rows[i].style.display = 'none';
                            rows[i].classList.remove('visible');
                        }
                    }
                });
                document.querySelector('#time').addEventListener('change', function(e) {
                    var time = e.target.value;
                    var rows = document.querySelectorAll('.record.visible');
                    if (time == 'All') {
                        for (var i = 0; i < rows.length; i++) {
                            rows[i].style.display = 'table-row';
                        }
                        return;
                    }
                    if (time == 'Upcoming') {
                        var nowTime = (new Date()).toLocaleTimeString()
                        if(nowTime[0] != '1')
                            nowTime = '0' + nowTime;

                        nowTime = nowTime.slice(0, 8);

                        for(var i = 0; i < rows.length; i++){
                            var starts = rows[i].children[2].innerHTML;
                            var ends = rows[i].children[3].innerHTML;

                            if(starts > nowTime){
                                rows[i].style.display = 'table-row';
                            }else{
                                rows[i].style.display = 'none';
                            }
                        }
                    }
                    if (time == 'Running') {
                        var nowTime = (new Date()).toLocaleTimeString()
                        if(nowTime[0] != '1')
                            nowTime = '0' + nowTime;

                        nowTime = nowTime.slice(0, 8);

                        for(var i = 0; i < rows.length; i++){
                            var starts = rows[i].children[2].innerHTML;
                            var ends = rows[i].children[3].innerHTML;

                            if(starts <= nowTime && nowTime <= ends){
                                rows[i].style.display = 'table-row';
                            }else{
                                rows[i].style.display = 'none';
                            }
                        }

                    }
                });
            </script>
        @endsection
