<?php

namespace App\Console\Commands\UseCase2;

use Illuminate\Console\Command;

class RunAllUseCase2Commands extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'use-case-2:run-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        print $this->description;
        $this->call('use-case-2:insert-company-dashboard-data');
        $this->call('use-case-2:insert-asset-dashboard-data');
        $this->call('use-case-2:insert-block-dashboard-data');
        $this->call('use-case-2:insert-field-dashboard-data');

        $this->call('use-case-2:insert-field-summary-data');
        $this->call('use-case-2:insert-block-summary-data');
        $this->call('use-case-2:insert-asset-summary-data');
        $this->call('use-case-2:insert-company-summary-data');

        $this->call('use-case-2:insert-field-chart-data');
        $this->call('use-case-2:insert-block-chart-data');
        $this->call('use-case-2:insert-asset-chart-data');
        $this->call('use-case-2:insert-company-chart-data');

        $this->call('use-case-2:insert-price-data');
        $this->call('use-case-2:insert-company-production-breakdown-data');
        $this->call('use-case-2:insert-quarterly-block-dashboard-data');
    }
}
