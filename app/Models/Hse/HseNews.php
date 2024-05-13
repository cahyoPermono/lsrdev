<?php

namespace App\Models\Hse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HseNews extends Model
{
    use HasFactory;
    protected $table = "hse_news";

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
        'start_at',
        'end_at',
    ];
}
