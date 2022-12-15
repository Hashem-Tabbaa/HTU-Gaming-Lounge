<!DOCTYPE html>
<html lang="en">
    <head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/images/favicon.ico"/>

    <title>HTU Gaming Lounge</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Link the style sheet in resources --}}
    <link rel="stylesheet" href="/css/dash.css">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/util.css">

    {{-- Link Bootstrap & JS--}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>


    {{-- Link SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    </head>
    <body >
        <header class="">
            <nav class="navbar-sm navbar-light p-0 m-0" style="background-color: #e9ecef ;">
            <div class="container d-flex justify-content-between p-0">
                <a class="navbar-brand" href="/arena" class="m-auto">
                <img src="/images/HTU Logo200.png" width="100" height="auto">
                </a>
                @if(Auth::check())
                    <div class="d-flex">
                        @if(Auth::user()->role == 'admin')
                            <a class="logout-btn" style="margin-right: 10px" href="/admin/settings">settings</a>

                        @else
                        <a class="logout-btn" style="margin-right: 10px" href="/profile">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            {{ Auth::user()->fname }}
                        </a>
                        @endif
                        <a class="logout-btn" href="/logout">Log Out </a>
                    </div>
                @else
                    <div class="d-flex justify-content-between">
                        <a class="logout-btn" style="margin-right: 10px" href='/login'>Log in </a>
                        <a class="logout-btn" href='/register'>Register </a>
                    </div>
                @endif
            </div>
            </nav>
        </header>
        @include('sweet::alert')
        @yield('content')
    </body>
</html>
