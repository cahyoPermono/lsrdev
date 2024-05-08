<?php

namespace App\Models\Hse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HseLeasonLearned extends Model
{
    use HasFactory;
    protected $table = "hse_leason_learned";

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
