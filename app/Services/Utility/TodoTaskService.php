<?php
namespace App\Services\Utility;
use App\Models\Util\TaskTodo;

class TodoTaskService
{
     public function __construct(
          public $model = TaskTodo::class,
     ) {
     }
     public function findAllTask($email)
     {
          $tasks = $this->model::where('email', $email)->select(['total_task', 'module_key'])->get();

          $totalTask = $tasks->sum('total_task');
          $tasks =  $tasks->map(function ($task) {
               $title = match ($task->module_key) {
                    "oim_approval" => "OIM Approval",
                    default => "N/A",
               };
               return [
                    'title' => $title,
                    'description' => "You have {$task->total_task} {$title} tasks",
                    'module_key' => $task->module_key
               ];
          });

          return [
               'total_task' => $totalTask,
               'tasks' => $tasks
          ];
     }
}