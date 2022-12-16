<?php

namespace App\Console\Commands;

use App\Models\Reservation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TruncateOldReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservations:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command is responsible for deleting old reservations';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(){

        // empty the reservations table
        Reservation::all()->each(function($reservation){
            $reservation->delete();
        });
    }
}
