<?php

namespace App\Console\Commands\Hse;

use Illuminate\Console\Command;

class RunAllHseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hse:run-all';

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
        $this->call('hse:insert-hse-banner-campaign');
        $this->call('hse:insert-hse-calendar-event');
        $this->call('hse:insert-hse-document');
        $this->call('hse:insert-hse-leason-learned');
        $this->call('hse:insert-hse-news');
        $this->call('hse:insert-hse-popup-campaign');
        $this->call('hse:insert-hse-poster');
        $this->call('hse:insert-hse-quizz');
    }
}
