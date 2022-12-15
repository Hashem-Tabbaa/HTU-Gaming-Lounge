@extends('layouts.layout')
@section('content')

<span class="login100-form-title p-b-48 m-auto" style="width: fit-content">
    <img src="./images/HTU Logo-250px.png" class="main-img">
</span>

<div class="container d-flex student">

    @foreach ($games as $game)
        <?php
            $image_path = "/images/" . $game->name . ".gif";
            $reservation_path = "/reservation/" . $game->name;
        ?>
        <div class="card">
            <div class="box">
            <div class="content">
            <img src={{$image_path}} alt="" width="auto" height="125">
                <h3 class="mt-5">{{$game->name}}</h3>
                <a href= {{$reservation_path}}>Reserve Now</a>
            </div>
            </div>
        </div>
    @endforeach
    @if ($errors->any())
          <script>
            Swal.fire({
              icon: "error",
              title: "Reservation Failed",
              text: "There is no available slot for this game.",
              showConfirmButton: true,
              confirmButtonText: "OK",
            });
          </script>
      @endif
</div>

@endsection
