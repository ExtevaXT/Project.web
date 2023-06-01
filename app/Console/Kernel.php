<?php

namespace App\Console;

use App\Jobs\ServerStatus;
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
        $schedule->command('bot:lot-create 10')->everySixHours()->withoutOverlapping();
        $schedule->command('bot:lot-bid 2')->everyThreeHours()->withoutOverlapping();
        $schedule->command('bot:lot-buyout 10')->daily()->withoutOverlapping();

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
