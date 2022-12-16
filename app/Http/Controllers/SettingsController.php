<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Game;

class SettingsController extends Controller{

    public function index(){
        if (Gate::denies('admin'))
            return redirect('/');

        $games = Game::all();

        return view('admin.settings', ['games' => $games]);
    }

    public function update(Request $request){
        if (Gate::denies('admin'))
            return redirect('/');

        $game_name = $request->input('name');
        Game::where('name', $game_name)->update(['start_time' => $request->input('start_time')
                                                    ,'end_time' => $request->input('end_time')
                                                    , 'session_duration' => $request->input('session_duration')
                                                    , 'sessions_capacity' => $request->input('sessions_capacity')
                                                ]);
        // return the ajax response
        return $request->input('name');
    }
}
