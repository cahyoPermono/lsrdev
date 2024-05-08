<?php

namespace App\Models\Hse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HseSafetyPoster extends Model
{
    use HasFactory;
    protected $table = "hse_safety_posters";

    protected $guarded = [];
}
