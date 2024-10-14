<?php
namespace App\Services\Utility;
use App\Models\Util\TaskTodo;
use Illuminate\Support\Facades\DB;

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
          $tasks = $tasks->map(function ($task) {
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

     public function incrementTaskByEmail($email)
     {
          $task = $this->model::query()
               ->where('email', $email)
               ->where('module_key', 'oim_approval')
               ->first();
          if($task){
               $task->update([
                    'total_task' => DB::raw('total_task+1')
               ]);
          }else{
               $this->model::create([
                    'email' => $email,
                    'module_key' => 'oim_approval',
                    'total_task' => 1
               ]);
          }
     }
}