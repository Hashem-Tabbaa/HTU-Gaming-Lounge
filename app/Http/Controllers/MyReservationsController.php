<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Reservation;
use App\Models\Game;
use Illuminate\Support\Carbon;
use App\Models\User;

class MyReservationsController extends Controller
{

    public function index()
    {

        if (Gate::denies('user'))
            return redirect('/login');

        if (Gate::allows('notverified'))
            return redirect('/verifyemail');

        $myReservations = Reservation::where('student1_email', auth()->user()->email)
            ->orWhere('student2_email', auth()->user()->email)
            ->orWhere('student3_email', auth()->user()->email)
            ->orWhere('student4_email', auth()->user()->email)
            ->get();

        return view('myreservations', ['myreservations' => $myReservations]);
    }

    public function cancel()
    {
        if (Gate::denies('user'))
            return redirect('/login');

        if (Gate::allows('notverified'))
            return redirect('/verifyemail');


        try {
            $reservation_id = request('id');
            $reservation = Reservation::find($reservation_id);
            $start_time = $reservation->res_time;
            $closing_time = Game::max('end_time');
            $current_time = Carbon::now()->addHours(3)->toTimeString();

            if ($current_time >= $start_time && $current_time <= $closing_time)
                return 'You cannot cancel a reservation that has finished or is currently in progress.';


            if(!$this->isOwner($reservation)){
                auth()->user()->is_banned = 1;
                auth()->user()->save();
                return "You cannot cancel others' reservations! You have been banned.";
            }

            $users_emails = [$reservation->student1_email, $reservation->student2_email, $reservation->student3_email, $reservation->student4_email];
            $users = User::whereIn('email', $users_emails)->get();
            foreach($users as $user){
                $user->number_of_reservations--;
                $user->save();
            }

            $reservation->delete();

            return $reservation_id;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    function isOwner($reservation){
        return strtolower($reservation->student1_email) == strtolower(auth()->user()->email) || strtolower($reservation->student2_email) == strtolower(auth()->user()->email) || strtolower($reservation->student3_email) == strtolower(auth()->user()->email) || strtolower($reservation->student4_email) == strtolower(auth()->user()->email);
    }
}
