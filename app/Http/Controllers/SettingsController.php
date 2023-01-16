<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Game;
use App\Models\Reservation;
use App\Models\User;
use Exception;

class SettingsController extends Controller
{

    public function index()
    {
        if (Gate::denies('admin'))
            return redirect('/');

        $games = Game::all();
        $users = User::where('is_banned', "1")->get();

        return view('admin.settings', ['games' => $games, 'users' => $users]);
    }

    public function update(Request $request)
    {
        if (Gate::denies('admin'))
            return redirect('/');

        $game_name = $request->input('name');
        Game::where('name', $game_name)->update([
            'start_time' => $request->input('start_time'), 'end_time' => $request->input('end_time'), 'session_duration' => $request->input('session_duration'), 'sessions_capacity' => $request->input('sessions_capacity')
        ]);

        // get users who have reservations for this game
        $resrevations = Reservation::where('game_name', $game_name)->get();
        // for each user, delete his reservations and change the number of reservations
        foreach ($resrevations as $reservation) {
            $users = User::where('email', $reservation->student1_email)->orWhere('email', $reservation->student2_email)->
            orWhere('email', $reservation->student3_email)->orWhere('email', $reservation->student4_email)->get();
            foreach ($users as $user) {
                $user->number_of_reservations = $user->number_of_reservations - 1;
                $user->save();
            }
            $reservation->delete();
        }
        // return the ajax response
        return $request->input('name');
    }
    public function unban(Request $request)
    {
        if (Gate::denies('admin'))
            return redirect('/');

        $email = $request->input('email');
        User::where('email', $email)->update(['is_banned' => '0']);

        // return the ajax response
        return $email;
    }
    public function ban(Request $request)
    {
        if (Gate::denies('admin'))
            return redirect('/');

        $email = $request->input('email');

        try {
            User::where('email', $email)->update(['is_banned' => '1']);
        } catch (Exception $e) {
            return "User not found";
        }
        return redirect('/admin/settings');
    }
    public function updateNumberOfReservations(Request $request){
        if (Gate::denies('admin'))
            return redirect('/');

        $max_number_of_reservations = $request->input('max_num_of_res');
        $games = Game::all();
        foreach ($games as $game) {
            try{
                $game->max_number_of_reservations = $max_number_of_reservations;
                $game->save();
            }catch(Exception $e){
                return $e->getMessage();
            }
        }
        Reservation::truncate();
        User::all()->each(function ($user) {
            $user->number_of_reservations = 0;
            $user->save();
        });
        

        // return the ajax response
        return 'success';
    }
}
