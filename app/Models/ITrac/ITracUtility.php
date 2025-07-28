<?php

namespace App\Models\ITrac;

use Illuminate\Database\Eloquent\Model;
use Laililmahfud\Adminportal\Traits\HasDatatable;
use Laililmahfud\Adminportal\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ITracUtility extends Model
{
    use HasFactory,HasUuid,HasDatatable;

    protected $table = "itrac_utility";
}
