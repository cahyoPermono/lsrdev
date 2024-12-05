<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Enum\Status;
use App\Models\Settings;
use App\Constanta\Constanta;
use App\Models\Account\User;
use Illuminate\Console\Command;

class DeactivateInactiveUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:deactivate-inactive-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deactivate inactive users after 90 days of inactivity';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $minActiveDay = Settings::where('key', Constanta::SETTING::MIN_ACTIVE_DAY)->first();
        $thresholdDate = Carbon::now()->subDays(intval($minActiveDay?->value) ?: 90);
        User::query()
            ->where('last_login', '<=', $thresholdDate)
            ->where('status', Status::Active)
            ->update([
                'status' => Status::InActive
            ]);

    }
}