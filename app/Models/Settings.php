<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laililmahfud\Adminportal\Traits\HasDatatable;
use Laililmahfud\Adminportal\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Settings extends Model
{
    use HasFactory,HasUuid,HasDatatable;

    protected $table = "settings";
    protected $fillable = ["value","key"];
}
