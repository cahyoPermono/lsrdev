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
        $this->runJob($schedule,'07:00');  //Run the task every day at 07:00
        $this->runJob($schedule,'10:00');  //Run the task every day at 10:00
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
    }

    private function runJob(Schedule $schedule,$time){
        $schedule->command('use-case-2:insert-company-dashboard-data')->dailyAt($time); 
        $schedule->command('use-case-2:insert-asset-dashboard-data')->dailyAt($time); 
        $schedule->command('use-case-2:insert-block-dashboard-data')->dailyAt($time); 
        $schedule->command('use-case-2:insert-field-dashboard-data')->dailyAt($time); 


        $schedule->command('use-case-2:insert-company-chart-data')->dailyAt($time); 
        $schedule->command('use-case-2:insert-asset-chart-data')->dailyAt($time); 
        $schedule->command('use-case-2:insert-block-chart-data')->dailyAt($time); 
    }
}
