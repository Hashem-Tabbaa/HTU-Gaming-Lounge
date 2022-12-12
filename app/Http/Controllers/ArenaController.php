<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use Illuminate\Support\Facades\Session;

class ArenaController extends Controller{

    public function index(){
        $games = Game::select('id', 'name')->get();
        return view('arena', ['games' => $games]);
    }

}
