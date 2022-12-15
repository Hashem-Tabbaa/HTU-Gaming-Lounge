<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller{

    public function index(){

        if(Gate::denies('admin'))
            return redirect('/');

        $reservations = Reservation::all();
        // return $resrevations;
        return view('admindash', ['reservations' => $reservations]);
    }

}
