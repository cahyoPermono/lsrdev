<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laililmahfud\Adminportal\Traits\HasUuid;

class UserActivity extends Model
{
    use HasFactory, HasUuid;
    protected $table = 'user_activities';
    protected $guarded = [];
}