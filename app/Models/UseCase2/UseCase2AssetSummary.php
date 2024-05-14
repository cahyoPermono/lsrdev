<?php

namespace App\Models\UseCase2;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UseCase2AssetSummary extends Model
{
    use HasFactory;
    protected $table = "use_case2_asset_summary";

    protected $guarded = [];
    protected $casts = [
        'gross' => 'array',
        'net' => 'array',
    ];
}
