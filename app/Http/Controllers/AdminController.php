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


        $numberOfRegisteredUsers = User::all()->count();

        // get all reservations and students first and last name
        $reservations = Reservation::all();
        foreach($reservations as $reservation){
            if($reservation->student1_email != null){
                $user = User::where('email', $reservation->student1_email)->first();
                $reservation->student1_name = "( " . $user->fname . ' ' . $user->lname." )";
            }
            if($reservation->student2_email != null){
                $user = User::where('email', $reservation->student2_email)->first();
                $reservation->student2_name = "( " . $user->fname . ' ' . $user->lname." )";
            }
            if($reservation->student3_email != null){
                $user = User::where('email', $reservation->student3_email)->first();
                $reservation->student3_name = "( " . $user->fname . ' ' . $user->lname." )";
            }
            if($reservation->student4_email != null){
                $user = User::where('email', $reservation->student4_email)->first();
                $reservation->student4_name = "( " . $user->fname . ' ' . $user->lname." )";
            }
        }

        return view('admin.admindash', ['reservations' => $reservations, 'numberOfRegisteredUsers' => $numberOfRegisteredUsers]);
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
        return ['success' => true];
    }
}
