<?php

namespace App\Models\Hse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HseDocument extends Model
{
    use HasFactory;
    protected $table = "hse_documents";

    protected $guarded = [];
}
