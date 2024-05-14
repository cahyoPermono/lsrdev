<?php

namespace App\Models\UseCase2;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UseCase2CompanyData extends Model
{
    use HasFactory;
    protected $table = "use_case2_company_data";

    protected $guarded = [];
    protected $casts = [
        'gas_net' => 'array',
        'gas_gross' => 'array',
        'oil_net' => 'array',
        'oil_gross' => 'array',
    ];
}
