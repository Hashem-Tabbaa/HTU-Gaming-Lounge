<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;
use App\Models\Game;
use Illuminate\Support\Facades\Artisan;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule){
        // $closing_time = Game::max('end_time');
        // $schedule->call(function () {
        //     Reservation::all()->delete();
        // })
        //     ->dailyAt($closing_time)
        //     ->days([Schedule::SUNDAY, Schedule::MONDAY, Schedule::TUESDAY, Schedule::WEDNESDAY, Schedule::THURSDAY])
        //     ->timezone('Asia/Amman');
        $closing_time = Game::max('end_time');
        $schedule->command('reservations:delete')
            ->dailyAt($closing_time)
            ->days([Schedule::SUNDAY, Schedule::MONDAY, Schedule::TUESDAY, Schedule::WEDNESDAY, Schedule::THURSDAY])
            ->timezone('Asia/Amman');



    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
