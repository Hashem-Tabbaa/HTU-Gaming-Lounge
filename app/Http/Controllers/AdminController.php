<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Gate;
use App\Models\Game;

class AdminController extends Controller{

    public function index(){

        if(Gate::denies('admin'))
            return redirect('/');

        //sort reservations by date ascending
        $reservations = Reservation::orderBy('res_time', 'asc')->get();

        return view('admin.admindash', ['reservations' => $reservations]);
    }

    public function removeReservation($request){
        return "hello";
    }
}
