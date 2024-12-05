<?php

namespace App\Models\Util;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laililmahfud\Adminportal\Traits\HasUuid;

class TaskTodo extends Model
{
    use HasFactory,HasUuid;
    protected $table = "task_todos";

    protected $guarded = [];
}
