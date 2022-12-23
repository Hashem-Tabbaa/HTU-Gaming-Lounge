<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

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
        $emails = [$reservation->student1_email, $reservation->student2_email, $reservation->student3_email, $reservation->student4_email];
        foreach($emails as $email){
            if($email != null){
                $user = User::where('email', $email)->first();
                $user->number_of_reservations -= 1;
                $user->save();
            }
        }
        $reservation->delete();
        return $request->id;
    }

    public function removeAllReservations(Request $request){
        if (Gate::denies('admin'))
            return redirect('/');

        $reservations = Reservation::all();
        foreach($reservations as $reservation){
            $reservation->delete();
            $emails = [$reservation->student1_email, $reservation->student2_email, $reservation->student3_email, $reservation->student4_email];
            foreach($emails as $email){
                if($email != null){
                    $user = User::where('email', $email)->first();
                    if($user->number_of_reservations > 0){
                        $user->number_of_reservations = 0;
                        $user->save();
                    }
                }
            }
        }
        return redirect('/admin');
    }
}
