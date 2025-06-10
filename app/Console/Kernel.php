<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Schedule the overdue goals notification to run daily at 9 AM
        $schedule->command('goals:notify-overdue')->dailyAt('09:00');
        // $schedule->command('reminders:check')->everyMinute(); // Removed as per user's request
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        // Automatically load all Artisan commands from the Commands directory
        $this->load(__DIR__.'/Commands');

        // Load custom console routes
        require base_path('routes/console.php');
    }
}
