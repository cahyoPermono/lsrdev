<?php

namespace App\Console\Commands\Utility;

use App\Helpers\Url;
use App\Helpers\MedcoRestful;
use App\Models\Util\TaskTodo;
use Illuminate\Console\Command;

class CalculateTaskTodoUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'utility:calculate-task-todo-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Utility - Calculate and insert task todo user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $restResponse = MedcoRestful::fetchData(
            url: Url::GetRequestApproverList,
        );
        if (!$restResponse) {
            return [];
        }

        $approvers = collect($restResponse)->whereNotNull('email')->values();
        foreach ($approvers as $approver) {
            $totalTask = 0;
            $taskReservation = MedcoRestful::fetchData(
                url: Url::GetReservationByApprovePayrol,
                query: [
                    'payroll' => @$approver['user_id']
                ]
            );
            if ($taskReservation) {
                $totalTask = collect($restResponse)
                    ->whereNull('approved_status')
                    ->where('reservation_status', '!=', 'Cancelled')
                    ->count();
            }

            TaskTodo::updateOrCreate([
                'email' => @$approver['email'],
            ], [
                'email' => @$approver['email'],
                'module_key' => 'oim_approval',
                'total_task' => $totalTask,
            ]);
        }
    }
}
