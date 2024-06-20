<?php

namespace App\Models\Hse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HseEvent extends Model
{
    use HasFactory;
    protected $table = "hse_events";

    protected $guarded = [];
}
