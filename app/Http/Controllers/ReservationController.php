<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\reservation;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Gate;
use PhpParser\Node\Scalar\MagicConst\Line;

class ReservationController extends Controller{

    public function index($game_name){

        if (Gate::allows('notverified'))
            return redirect('/verifyemail');

        if (Gate::denies('user'))
            return redirect('/login');


        $game = Game::where('name', $game_name)->first();
        $timeSlots = $this->generateTimeSlots($game);
        return view('reservation', ['game' => $game, 'timeSlots' => $timeSlots]);
    }
    public function reserve(){

        if (Gate::allows('notverified'))
            return redirect('/verifyemail');
        if(Gate::denies('user'))
            return redirect('/login');

        $time_slot = Date("H:i:s", strtotime(request('time_slot')));
        $game = request('game');
        $emails = array();
        $emails[0] = auth()->user()->email;
        for($i = 2 ; $i<=4 ; $i++){
            if(request($i) != null)
                array_push($emails, request('email'.$i));
        }

        // Check if the time slot is already reserved
        $reservation = Reservation::where('game_name', $game)->where('res_time', $time_slot)->first();
        if($reservation != null)
            return redirect('/reservation/'.$game)->with('error', 'Time slot already reserved');
        // Check if the user has already reserved a time slot for this game
        $reservation = Reservation::
        whereIn('student1_email', $emails)->
        OrWhereIn('student2_email', $emails)->
        OrWhereIn('student3_email', $emails)->
        OrWhereIn('student4_email', $emails)->
        first();

        if($reservation != null)
            return redirect('/reservation/'.$game)->with('error', 'One of the players has already reserved a game today');

        // Create reservation
        $reservation = new Reservation();
        $reservation->game_name = $game;
        $reservation->res_time = $time_slot;
        foreach ($emails as $key => $email){
            $reservation->{'student'.($key+1).'_email'} = $email;
        }
        $reservation->save();

        return redirect('/reservation/'.$game)->with('success', 'Reservation successful');
    }
    private function generateTimeSlots($game){

        $start = strtotime($game->start_time);
        $end = strtotime($game->end_time);
        $session_duration = $game->session_duration;

        // Generate time slots
        $timeSlots = [];
        $curr = $start;
        while($curr < $end){
            $timeSlots[] = Date("H:i", $curr);
            $curr += 60 * $session_duration;
        }

        // Remove reserved time slots
        $reservations = Reservation::where('game_name', $game->name)->get();

        foreach($reservations as $reservation){
            $time = Date("H:i", strtotime($reservation->res_time));
            $key = array_search($time, $timeSlots);
            if($key !== false)
                unset($timeSlots[$key]);
        }

        return $timeSlots;
    }
}
