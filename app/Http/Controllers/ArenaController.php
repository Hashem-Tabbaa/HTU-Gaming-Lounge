<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use Illuminate\Support\Facades\Session;

class ArenaController extends Controller{

    public function index(){
        $games = Game::all();
        return view('arena', ['games' => $games]);
    }

}
