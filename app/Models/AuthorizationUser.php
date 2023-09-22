<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laililmahfud\Adminportal\Traits\HasDatatable;
use Laililmahfud\Adminportal\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AuthorizationUser extends Model
{
    use HasFactory,HasUuid,HasDatatable;

    protected $table = "authorization_users";
    protected $fillable = ["email","modules_id"];
}
