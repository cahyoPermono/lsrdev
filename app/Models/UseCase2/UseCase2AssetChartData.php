<?php

namespace App\Models\UseCase2;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UseCase2AssetChartData extends Model
{
    use HasFactory;
    protected $table = "use_case2_asset_chart_data";

    protected $guarded = [];
    protected $casts = [
        'actual' => 'array',
        'budget' => 'array',
        'outlook' => 'array',
    ];
}
