@extends('layouts.layout')
@section('content')
    <ul class="nav nav-tabs flex-row nav-justified" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="games-settings-tab" data-toggle="tab" href="#games-settings" role="tab"
                aria-controls="games-settings" aria-selected="true">Games Settings</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="students-settings-tab" data-toggle="tab" href="#students-settings" role="tab"
                aria-controls="students-settings" aria-selected="false">Students Settings</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="games-settings" role="tabpanel" aria-labelledby="games-settings-tab">
            <div class="container d-flex">
                @foreach ($games as $game)
                    <?php
                    $image_path = '/images/' . $game->name . '.gif';
                    $reservation_path = '/reservation/' . $game->name;
                    ?>
                    <div class="card">
                        <div class="box-admin">
                            <div class="content">
                                <img src={{ $image_path }} alt="" width="auto" height="75">
                                <h4 class="mb-5">{{ $game->name }}</h4>
                                <form class="form-group d-flex flex-column form-games" action="/admin/settings/update"
                                    method="post" id="{{ $game->name }}">
                                    @csrf
                                    <input type="hidden" name="name" value="{{ $game->name }}">
                                    <div>
                                        <label for="start_time">Start Time: </label>
                                        <input type="time" name="start_time" id="start_time" step="3600"
                                            value="{{ $game->start_time }}">
                                    </div>
                                    <div>
                                        <label for="end_time">End Time: </label>
                                        <input type="time" name="end_time" id="end_time" value="{{ $game->end_time }}">
                                    </div>
                                    <div>
                                        <label for="session_duration">Session Duration: </label>
                                        <input type="number" name="session_duration" id="session_duration"
                                            value="{{ $game->session_duration }}" style="width: 50px" min="5">
                                    </div>
                                    <div>
                                        <label for="sessions_capacity">Sessions Capacity: </label>
                                        <input type="number" name="sessions_capacity" id="sessions_capacity"
                                            value="{{ $game->sessions_capacity }}" style="width: 50px" min="0">
                                    </div>
                                    <p class="text-success" id="success_{{ $game->name }}" hidden>Settings saved successfully</p>
                                    <button type="submit" class="btn btn-primary mt-3">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="tab-pane fade" id="students-settings" role="tabpanel" aria-labelledby="students-settings-tab">
            <br>
            <div class="p-3">
                <form class="form-ban" action="/admin/settings/ban" method="POST" class="form">
                    @csrf
                    <label style="margin-left: 15px" class="" for="studentEmail">Ban a student</label>
                    <div class="d-flex flex-row">
                        <div>
                            <input class="form-control  " type="text" name="email" placeholder="Student Email" id="email">
                        </div>
                        <div>
                            <button type="submit" class="btn btn-danger">Ban</button>
                        </div>
                    </div>

                </form>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Student First Name</th>
                        <th scope="col">Student Last Name</th>
                        <th scope="col">Student Email</th>


                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="" id="{{$user->email}}">
                            <td>{{ $user->fname }}</td>
                            <td>{{ $user->lname }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="text-center">
                                <form class="form-unban" action="/admin/settings/unban" method="POST" class="form">
                                    @csrf
                                    <input type="text " name="email" value="{{ $user->email }}" hidden>
                                    <button type="submit" class="btn btn-danger">Unban</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>




        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.form-games').submit(function(e) {
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
                        document.getElementById('success_' + response).hidden = false;
                        setTimeout(function() {
                            document.getElementById('success_' + response).hidden = true;
                        }, 2000);
                    }
                });
            });
        });

        $(document).ready(function() {
            $('.form-unban').submit(function(e) {
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
                        document.getElementById(response).hidden = true;
                    }
                });
            });
        });
    </script>
@endsection
