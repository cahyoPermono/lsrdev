<?php

namespace App\Models\Account;

use App\Enum\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laililmahfud\Adminportal\Traits\HasDatatable;
use Laililmahfud\Adminportal\Traits\HasUuid;

class User extends Model
{
    use HasFactory, HasUuid,HasDatatable;

    protected $table = 'users';
    protected $guarded = [];

    protected $casts = [
        'status' => Status::class,
        'last_login' => 'datetime'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}