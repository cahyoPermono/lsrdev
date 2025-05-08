<?php

namespace App\Models\UseCase2;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UseCase2Price extends Model
{
    use HasFactory;
    protected $table = "use_case2_price";

    protected $casts = [
        'value' => 'float',
        'delta' => 'float',
        'percent' => 'float',
    ];

    protected $guarded = [];
}
