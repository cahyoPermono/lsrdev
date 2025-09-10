<?php

namespace App\Models\UseCase2;

use Illuminate\Database\Eloquent\Model;

class UseCase2CompanyYtdProductionBreakdown extends Model
{
    protected $table = 'use_case2_company_ytd_production_breakdown';

    protected $fillable = [
        'date',
        'country_code',
        'type',
        'working_interest',
        'ytd_production',
        'budget',
        'delta',
        'percent',
    ];

    protected $casts = [
        'date' => 'date',
        'ytd_production' => 'float',
        'budget' => 'float',
        'delta' => 'float',
        'percent' => 'float',
    ];
}
