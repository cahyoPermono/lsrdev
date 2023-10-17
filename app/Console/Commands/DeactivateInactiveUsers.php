<?php

namespace App\Console\Commands;

use App\Enum\Status;
use App\Models\Account\User;
use App\Models\Settings;
use Illuminate\Console\Command;
use Carbon\Carbon;

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
        $maxInActiveDay = Settings::where('key', 'min_active_day')->first();
        $thresholdDate = Carbon::now()->subDays($maxInActiveDay?->value ?: 90);
        User::query()
            ->where('last_login', '<=', $thresholdDate)
            ->where('status', Status::Active)
            ->update([
                'status' => Status::InActive
            ]);

    }
}