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
        $dailyJobTime = "06:30";

        $schedule->command('use-case-2:insert-company-dashboard-data')->everyThirtyMinutes(); 
        $schedule->command('use-case-2:insert-asset-dashboard-data')->everyThirtyMinutes(); 
        $schedule->command('use-case-2:insert-block-dashboard-data')->everyThirtyMinutes(); 
        $schedule->command('use-case-2:insert-field-dashboard-data')->everyThirtyMinutes(); 

        $schedule->command('use-case-2:insert-company-summary-data')->everyThirtyMinutes(); 
        $schedule->command('use-case-2:insert-asset-summary-data')->everyThirtyMinutes(); 
        $schedule->command('use-case-2:insert-block-summary-data')->everyThirtyMinutes(); 
        $schedule->command('use-case-2:insert-field-summary-data')->everyThirtyMinutes(); 


        $schedule->command('use-case-2:insert-company-chart-data')->everyThirtyMinutes(); 
        $schedule->command('use-case-2:insert-asset-chart-data')->everyThirtyMinutes(); 
        $schedule->command('use-case-2:insert-block-chart-data')->everyThirtyMinutes(); 
        $schedule->command('use-case-2:insert-field-chart-data')->everyThirtyMinutes();

        $schedule->command('hse:run-all-hse-command')->dailyAt($dailyJobTime);

        $schedule->command('app:deactivate-inactive-users')->everyThirtyMinutes(); 
        $schedule->command('utility:calculate-task-todo-user')->everyFiveMinutes(); 
    }
}
