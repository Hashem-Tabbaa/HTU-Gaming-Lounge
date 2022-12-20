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

    public function removeReservation(Request $request){
        $reservation_id = $request->id;
        $reservation = Reservation::find($reservation_id);
        $reservation->delete();
        return $request->id;
    }

    public function removeAllReservations(Request $request){
        if (Gate::denies('admin'))
            return redirect('/');

        $reservations = Reservation::all();
        foreach($reservations as $reservation){
            $reservation->delete();
        }
        return redirect('/admin');
    }
}
