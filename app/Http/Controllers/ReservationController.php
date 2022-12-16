<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\reservation;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;

class ReservationController extends Controller{

    public function index($game_name){

        if (Gate::allows('notverified'))
            return redirect('/verifyemail');

        if (Gate::denies('user') && Gate::denies('admin'))
            return redirect('/login');


        $game = Game::where('name', $game_name)->first();
        $timeSlots = $this->generateTimeSlots($game);
        if($timeSlots == null)
            return back()->withErrors('There is no available slot for this game.');
            // return redirect('/arena')->withErrors('No time slots available for this game today');

        return view('reservation', ['game' => $game, 'timeSlots' => $timeSlots]);
    }
    public function reserve(){

        if (Gate::allows('notverified'))
            return redirect('/verifyemail');
        if(Gate::denies('user') && Gate::denies('admin'))
            return redirect('/login');

        $time_slot = Date("H:i:s", strtotime(request('time_slot')));
        $game = request('game');
        $emails = array();
        $emails[0] = auth()->user()->email;
        for($i = 2 ; $i<=4 ; $i++){
            if(request($i) != null)
                array_push($emails, request('email'.$i));
        }

        $users = User::whereIn('email', $emails)->where('verified', 1)->where('is_banned', 0)->get();
        if($users->count() != count($emails))
            return redirect('/reservation/'.$game)->with('error', 'One of the players is not registered or not verified');

        // Check if the time slot is already reserved
        $reservations = Reservation::where('game_name', $game)->where('res_time', $time_slot)->count();
        $sessions_capacity = Game::where('name', $game)->first()->sessions_capacity;
        $session_duration = Game::where('name', $game)->first()->session_duration;

        if($reservations == $sessions_capacity)
            return redirect('/reservation/'.$game)->with('error', 'The selected time slot is already reserved');
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
        $reservation->res_end_time = Date("H:i:s", strtotime($time_slot) + 60 * $session_duration);
        $reservation->session_duration = $session_duration;
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
        $sessions_capacity = $game->sessions_capacity;

        // Generate time slots
        $timeSlots = [];
        $timeSlotsFreq = [];
        $curr = $start;
        while($curr < $end){
            $timeSlots[] = Date("H:i", $curr);
            $timeSlotsFreq[Date("H:i", $curr)] = $sessions_capacity;
            $curr += 60 * $session_duration;
        }
        // Remove reserved time slots
        $reservations = Reservation::where('game_name', $game->name)->get();

        foreach($reservations as $reservation){
            $time = Date("H:i", strtotime($reservation->res_time));
            $timeSlotsFreq[$time]--;
        }
        foreach($timeSlotsFreq as $key => $value){
            if($value <= 0){
                $arrayKey = array_search($key, $timeSlots);
                unset($timeSlots[$arrayKey]);
            }
        }

        return $timeSlots;
    }
}
