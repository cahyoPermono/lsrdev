<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ITrac\ITracSchedule;

class ITracScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $schedules = [
            ['Grissik', 'Gelam', ['07:30', '13:00']],
            ['Grissik', 'Sumpal', ['07:30', '13:00']],
            ['Grissik', 'Dayung', ['07:30', '13:00']],
            ['Grissik', 'Rawa',   ['07:30', '13:00']],
            ['Grissik', 'Suban',  ['08:00']],
            ['Gelam', 'Grissik', ['14:30']],
            ['Gelam', 'Sumpal',  ['14:30']],
            ['Gelam', 'Dayung',  ['14:30']],
            ['Gelam', 'Rawa',    ['14:30']],
            ['Gelam', 'Suban',   ['14:30']],
            ['Sumpal', 'Grissik', ['09:00', '09:30', '14:30', '16:30']],
            ['Sumpal', 'Gelam',   ['09:00', '14:30', '16:30']],
            ['Sumpal', 'Dayung',  ['09:00', '09:30', '14:30', '16:30']],
            ['Sumpal', 'Rawa',    ['09:00', '09:30', '14:30', '16:30']],
            ['Sumpal', 'Suban',   ['09:00', '09:30', '14:30', '16:30']],
            ['Dayung', 'Grissik', ['08:00', '15:00']],
            ['Dayung', 'Gelam',   ['08:00', '15:00']],
            ['Dayung', 'Sumpal',  ['08:00', '15:00']],
            ['Dayung', 'Rawa',    ['08:00', '15:00']],
            ['Dayung', 'Suban',   ['10:00']],
            ['Rawa', 'Grissik', ['15:30']],
            ['Rawa', 'Gelam',   ['15:30']],
            ['Rawa', 'Sumpal',  ['15:30']],
            ['Rawa', 'Dayung',  ['15:30']],
            ['Rawa', 'Suban',   ['15:30']],
            ['Suban', 'Grissik', ['07:30']],
            ['Suban', 'Dayung',  ['13:00']],
        ];

        foreach ($schedules as [$from, $to, $times]) {
            foreach ($times as $time) {
                ITracSchedule::create([
                    'from_location' => $from,
                    'to_location' => $to,
                    'departure_time' => $time,
                ]);
            }
        }
    }
}
