<?php

namespace App\Console;
use App\Services\Queue;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule
            ->call(function(){
                (new Queue)->send();
            })
            ->dailyAt('08:00')->name('updateFeeds')->withoutOverlapping();
    }
}
