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
        // $schedule->command('inspire')->hourly();
        $this->runJob($schedule); 
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
    }

    private function runJob(Schedule $schedule){
        $dailyJobTime = "06:00";

        $schedule->command('use-case-2:run-all')->everySixHours();
        $schedule->command('hse:run-all')->everySixHours();

        $schedule->command('app:deactivate-inactive-users')->everyThirtyMinutes(); 
        $schedule->command('utility:calculate-task-todo-user')->everyFiveMinutes(); 
    }
}
