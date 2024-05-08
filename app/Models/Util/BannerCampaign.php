<?php

namespace App\Models\Util;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerCampaign extends Model
{
    use HasFactory;
    protected $table = "banner_campaigns";

    protected $guarded = [];
}
