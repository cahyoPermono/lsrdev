<?php

namespace App\Models\ITrac;

use Illuminate\Database\Eloquent\Model;
use Laililmahfud\Adminportal\Traits\HasDatatable;
use Laililmahfud\Adminportal\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ITracPersonnelCategory extends Model
{
    use HasFactory,HasUuid,HasDatatable;

    protected $table = "itrac_personnel_category";

    // Accessor for the 'Days' attribute
    public function getDaysAttribute($value)
    {
        // Convert the comma-separated string to an array
        return array_map('intval', explode(';', $value));
    }

    // Mutator for the 'Days' attribute
    public function setDaysAttribute($value)
    {
        // Convert the array to a comma-separated string
        $this->attributes['days'] = implode(';', $value);
    }
}
