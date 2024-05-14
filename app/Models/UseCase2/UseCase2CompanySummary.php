<?php

namespace App\Models\UseCase2;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UseCase2CompanySummary extends Model
{
    use HasFactory;
    
    protected $table = "use_case2_company_summary";

    protected $guarded = [];
    protected $casts = [
        'gross' => 'array',
        'net' => 'array',
    ];
}
