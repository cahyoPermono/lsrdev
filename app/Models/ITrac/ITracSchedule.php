<?php
namespace App\Models\ITrac;

use Illuminate\Database\Eloquent\Model;

class ITracSchedule extends Model
{
    protected $table = 'itrac_schedules';

    protected $fillable = [
        'from_location',
        'to_location',
        'departure_time',
    ];
}
