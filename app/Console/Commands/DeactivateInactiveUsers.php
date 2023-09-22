<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Account\User;

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
        $thresholdDate = Carbon::now()->subDays(90);
        $inactiveUsers = User::where('last_login', '<=', $thresholdDate)->get();
        foreach ($inactiveUsers as $user) {
            $user->update(['is_active' => false]);
        }
        
        $this->info('Deactivated ' . count($inactiveUsers) . ' inactive users.');
    }
}
