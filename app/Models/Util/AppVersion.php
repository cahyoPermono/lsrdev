<?php

namespace App\Models\Util;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppVersion extends Model
{
    use HasFactory;
    protected $table = "app_versions";

    protected $guarded = [];
}
