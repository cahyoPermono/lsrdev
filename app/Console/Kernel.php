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
        $schedule->command('use-case-2:insert-company-dashboard-data')->hourly(); 
        $schedule->command('use-case-2:insert-asset-dashboard-data')->hourly(); 
        $schedule->command('use-case-2:insert-block-dashboard-data')->hourly(); 
        $schedule->command('use-case-2:insert-field-dashboard-data')->hourly(); 

        $schedule->command('use-case-2:insert-company-summary-data')->hourly(); 
        $schedule->command('use-case-2:insert-asset-summary-data')->hourly(); 
        $schedule->command('use-case-2:insert-block-summary-data')->hourly(); 
        $schedule->command('use-case-2:insert-field-summary-data')->hourly(); 


        $schedule->command('use-case-2:insert-company-chart-data')->hourly(); 
        $schedule->command('use-case-2:insert-asset-chart-data')->hourly(); 
        $schedule->command('use-case-2:insert-block-chart-data')->hourly(); 
    }
}
