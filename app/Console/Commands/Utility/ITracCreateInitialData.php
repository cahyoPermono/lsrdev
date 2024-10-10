<?php

namespace App\Console\Commands\Utility;

use App\Constanta\Constanta;
use App\Models\Settings;
use Illuminate\Console\Command;

class ITracCreateInitialData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'itrac:create-initial-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create initial itract data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->create(Constanta::SETTING::ITRAC_STATUS, json_encode([
            'ON-DUTY',
            'OFF-DUTY'
        ]));

        $this->create(Constanta::SETTING::ITRAC_SCHEDULE, json_encode([
            'Palembang 07:30',
            'Jambi 11:00',
            'Grissik 05:30',
            'Grissik 08:30',
            'Suban 05:30',
            'Dayung 05:30'
        ]));

        $this->create(Constanta::SETTING::ITRAC_TRANSIT_POINT, json_encode([
            'Via Grissik',
            'Direct to Location '
        ]));
    }

    private function create($key, $value)
    {
        $setting = Settings::where('key', $key)->first();
        if (!$setting) {
            Settings::create([
                'key' => $key,
                'value' => $value
            ]);
        }
    }
}
