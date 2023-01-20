<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\reservation;
use DateTimeZone;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Date;

class ReservationController extends Controller{

    public function index($game_name){

        if (Gate::allows('notverified'))
            return redirect('/verifyemail');

        if (Gate::denies('user') && Gate::denies('admin'))
            return redirect('/login');


        $game = Game::where('name', $game_name)->first();
        $timeSlots = $this->generateTimeSlots($game);

        // current time in time zone Asia/Amman
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

        try{
            $date = new \DateTime('now', new DateTimeZone('Asia/Amman'));
            $currentTime = $date->format('H:i');

            $time_slot = Date("H:i:s", strtotime(request('time_slot')));

            if($time_slot < $currentTime)
                return ['error' => 'You cannot reserve a time slot in that has already started'];

            $game = request('game');
            $emails = array();
            $emails[0] = auth()->user()->email;
            for($i = 2 ; $i<=4 ; $i++){
                if(request($i) != null)
                    array_push($emails, request('email'.$i));
            }

            $users = User::whereIn('email', $emails)->where('verified', 1)->where('is_banned', 0)->get();
            if ($users->count() != count($emails))
                return ['error' => 'One of the players is not verified or registered'];

            // Check if the time slot is already reserved
            $reservations = Reservation::where('game_name', $game)->where('res_time', $time_slot)->count();
            $sessions_capacity = Game::where('name', $game)->first()->sessions_capacity;
            $session_duration = Game::where('name', $game)->first()->session_duration;

            if($reservations == $sessions_capacity)
                return ['error' => 'This time slot is already reserved'];

            // Check if the user has exceeded the maximum number of reservations
            $max_number_of_reservations = Game::where('name', $game)->first()->max_number_of_reservations;

            foreach($emails as $email){
                $numberOfReservations = User::where('email', $email)->first()->number_of_reservations;
                if($numberOfReservations >= $max_number_of_reservations)
                    return ['error' => 'One of the players has already reserved the maximum number of reservations for today'];
            }

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


            // Update number of reservations for each user
            foreach($emails as $email){
                $user = User::where('email', $email)->first();
                $user->number_of_reservations++;
                $user->save();
            }

            return ['success' => 'Reservation created successfully'];
        }catch(Exception $e){
            return ['error' => 'An error occurred while creating the reservation, please try again later'];
        }
    }
    private function generateTimeSlots($game){
        try{
            $start = strtotime($game->start_time);
            $end = strtotime($game->end_time);
            $session_duration = $game->session_duration;
            $sessions_capacity = $game->sessions_capacity;

            // Generate time slots
            $timeSlots = [];
            $timeSlotsFreq = [];
            $curr = $start;

            $date = new \DateTime('now', new DateTimeZone('Asia/Amman'));
            $currentTime = $date->format('H:i');

            while($curr < $end){
                try{
                    if(Date("H:i", $curr) < $currentTime){
                        $curr += 60 * $session_duration;
                        continue;
                    }

                    $timeSlots[] = Date("H:i", $curr);
                    $timeSlotsFreq[Date("H:i", $curr)] = $sessions_capacity;
                    $curr += 60 * $session_duration;
                }catch (Exception $e){
                    $curr += 60 * $session_duration;
                    continue;
                }
            }
            // Remove reserved time slots
            $reservations = Reservation::where('game_name', $game->name)->get();

            foreach($reservations as $reservation){
                try{
                    $time = Date("H:i", strtotime($reservation->res_time));
                    $timeSlotsFreq[$time]--;
                }catch (Exception $e){
                    continue;
                }
            }
            foreach($timeSlotsFreq as $key => $value){
                try{
                    if($value <= 0){
                        $arrayKey = array_search($key, $timeSlots);
                        unset($timeSlots[$arrayKey]);
                    }
                }catch (Exception $e){
                    continue;
                }
            }
            return $timeSlots;
        }catch (Exception $e){
            return null;
        }
    }
}
