<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laililmahfud\Adminportal\Traits\HasDatatable;
use Laililmahfud\Adminportal\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Users extends Model
{
    use HasFactory,HasUuid,HasDatatable;

    protected $table = "users";
    protected $fillable = ["email","workforce","identify_provider","pts_id","platform","regid","status","last_login"];
}
