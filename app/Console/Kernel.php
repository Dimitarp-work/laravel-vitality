<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\NotifyOverdueGoals::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // Schedule your command to run daily at 9 am
        $schedule->command('app:notify-overdue-goals')->dailyAt('09:00');
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
