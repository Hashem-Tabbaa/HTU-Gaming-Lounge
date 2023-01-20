@extends('layouts.layout')
@section('content')

    <div style="width: fit-content" class="m-auto">
        Number of Registered students: {{ $numberOfRegisteredUsers}}
    </div>

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

    <div class="m-auto" style="width: fit-content">
        <form action="/admin/removeReservation/all" method="POST" class="deleteAll">
            @csrf
            <button type="submit" class="btn btn-danger">Delete <strong>All</strong></button>
        </form>
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
                <tr class="record okGame okTime {{ $reservation->game_name }}" id="res{{ $reservation->id }}">
                    <td>
                        <li>
                            <ul>{{ $reservation->student1_email }}  {{$reservation->student1_name}} </ul>
                            <ul>{{ $reservation->student2_email }}  {{$reservation->student2_name}} </ul>
                            <ul>{{ $reservation->student3_email }}  {{$reservation->student3_name}} </ul>
                            <ul>{{ $reservation->student4_email }}  {{$reservation->student4_name}} </ul>
                        </li>
                    </td>
                    <td>{{ $reservation->game_name }}</td>
                    <td>{{ $reservation->res_time }}</td>
                    <td>{{ $reservation->res_end_time }}</td>
                    <td class="text-center">
                        <form action="/admin/removeReservation" method="POST" class="form">
                            @csrf
                            <input type="number " name="id" value="{{ $reservation->id }}" hidden>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            <script>
                $(document).ready(function() {
                    $('.form').submit(function(e) {
                        e.preventDefault();
                        let form = $(this);
                        swal({
                            title: "Caution!",
                            text: "Are you sure you want to delete this reservation?",
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
                                        var id = data;
                                        var row = document.querySelector('#res' + id);
                                        console.log(row);
                                        row.hidden = true;
                                    }
                                })
                            }
                        });
                    })
                });
                $(document).ready(function() {
                    $('.deleteAll').submit(function(e) {
                        e.preventDefault();
                        let form = $(this);
                        swal({
                            title: "Caution!",
                            text: "Are you sure you want to delete ALL reservations?",
                            icon: "warning",
                            buttons: true,
                        }).then(function(isConfirm) {
                            if (isConfirm) {
                                $('#loader').show();
                                $.ajax({
                                    type: form.attr('method'),
                                    url: form.attr('action'),
                                    data: form.serialize(),
                                    success: function(response) {
                                        $('#loader').hide();
                                        var rows = document.querySelectorAll('.record');
                                        for (var i = 0; i < rows.length; i++) {
                                            rows[i].hidden = true;
                                        }
                                    }
                                });
                            }
                        })
                    });
                });

                document.querySelector('#game').addEventListener('change', function(e) {
                    var game = e.target.value;
                    var rows = document.querySelectorAll('.record');
                    if (game == 'All') {
                        for (var i = 0; i < rows.length; i++) {
                            rows[i].classList.add('okGame');
                            if (rows[i].classList.contains('okTime'))
                                rows[i].style.display = 'table-row';
                        }
                        return;
                    }
                    for (var i = 0; i < rows.length; i++) {
                        if (rows[i].classList.contains(game)) {
                            rows[i].classList.add('okGame');
                            if (rows[i].classList.contains('okTime'))
                                rows[i].style.display = 'table-row';
                        } else {
                            rows[i].classList.remove('okGame');
                            rows[i].style.display = 'none';
                        }
                    }
                });
                document.querySelector('#time').addEventListener('change', function(e) {
                    var time = e.target.value;
                    var rows = document.querySelectorAll('.record');
                    if (time == 'All') {
                        for (var i = 0; i < rows.length; i++) {
                            rows[i].classList.add('okTime');
                            if (rows[i].classList.contains('okGame'))
                                rows[i].style.display = 'table-row';
                        }
                        return;
                    }
                    if (time == 'Upcoming') {
                        var now = (new Date()).toLocaleTimeString('en-US', {
                            hour12: false,
                            hour: "2-digit",
                            minute: "2-digit",
                            second: "2-digit"
                        });

                        for (var i = 0; i < rows.length; i++) {
                            var starts = rows[i].children[2].innerHTML;
                            var ends = rows[i].children[3].innerHTML;

                            if (starts > now) {
                                rows[i].classList.add('okTime');
                                if (rows[i].classList.contains('okGame'))
                                    rows[i].style.display = 'table-row';
                            } else {
                                rows[i].classList.remove('okTime');
                                rows[i].style.display = 'none';
                            }
                        }
                    }
                    if (time == 'Running') {
                        var now = (new Date()).toLocaleTimeString('en-US', {
                            hour12: false,
                            hour: "2-digit",
                            minute: "2-digit",
                            second: "2-digit"
                        });

                        for (var i = 0; i < rows.length; i++) {
                            var starts = rows[i].children[2].innerHTML;
                            var ends = rows[i].children[3].innerHTML;

                            if (starts <= now && now <= ends) {
                                rows[i].classList.add('okTime');
                                if (rows[i].classList.contains('okGame'))
                                    rows[i].style.display = 'table-row';
                            } else {
                                rows[i].classList.remove('okTime');
                                rows[i].style.display = 'none';
                            }
                        }

                    }
                });
            </script>
        @endsection
