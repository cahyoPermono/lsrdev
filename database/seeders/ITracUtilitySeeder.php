<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ITracUtilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        $settings = [
            [
                'id' => 1,
                'value' => 'ON-DUTY',
                'key' => 'status',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'value' => 'OFF-DUTY',
                'key' => 'status',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'value' => 'Grissik 07:30',
                'key' => 'intersite_schedule',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'value' => 'Grissik 13:00',
                'key' => 'intersite_schedule',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'value' => 'Dayung 08:00',
                'key' => 'intersite_schedule',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 6,
                'value' => 'Dayung 15:00',
                'key' => 'intersite_schedule',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 7,
                'value' => 'Sumpal 09:30',
                'key' => 'intersite_schedule',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 8,
                'value' => 'Sumpal 16:30',
                'key' => 'intersite_schedule',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 9,
                'value' => 'Sumpal 09:00',
                'key' => 'intersite_schedule',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 10,
                'value' => 'Sumpal 14:30',
                'key' => 'intersite_schedule',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 11,
                'value' => 'Rawa 15:30',
                'key' => 'intersite_schedule',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 12,
                'value' => 'Gelam 14:30',
                'key' => 'intersite_schedule',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 13,
                'value' => 'Grissik to Suban (08:00)',
                'key' => 'intersite_schedule',
                'created_at' => '',
                'updated_at' => $now,
            ],
            [
                'id' => 14,
                'value' => 'Suban to Grissik (07:30)',
                'key' => 'intersite_schedule',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 15,
                'value' => 'Dayung to Suban (10:00)',
                'key' => 'intersite_schedule',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 16,
                'value' => 'Suban to Dayung (13:00)',
                'key' => 'intersite_schedule',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 17,
                'value' => 'Operation',
                'key' => 'department',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 18,
                'value' => 'Mechanic',
                'key' => 'department',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 19,
                'value' => 'Instrument',
                'key' => 'department',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 20,
                'value' => 'Electric',
                'key' => 'department',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 21,
                'value' => 'Maintenance',
                'key' => 'department',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 22,
                'value' => 'Engineering',
                'key' => 'department',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 23,
                'value' => 'PL/ROW',
                'key' => 'department',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 24,
                'value' => 'HDE Surveillance',
                'key' => 'department',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 25,
                'value' => 'Support Service',
                'key' => 'department',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 26,
                'value' => 'FRC',
                'key' => 'department',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 27,
                'value' => 'Security',
                'key' => 'department',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 28,
                'value' => 'LM/LF',
                'key' => 'department',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 29,
                'value' => 'General Service',
                'key' => 'department',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 30,
                'value' => 'OCS',
                'key' => 'department',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 31,
                'value' => 'HSE',
                'key' => 'department',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 32,
                'value' => 'Medical',
                'key' => 'department',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 33,
                'value' => 'MM',
                'key' => 'department',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 34,
                'value' => 'P&S',
                'key' => 'department',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 35,
                'value' => 'Marine Operation',
                'key' => 'department',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 36,
                'value' => 'Asset Integrity',
                'key' => 'department',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 37,
                'value' => 'Operating Integrity',
                'key' => 'department',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 38,
                'value' => 'Engineering',
                'key' => 'department',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 39,
                'value' => 'IT',
                'key' => 'department',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 40,
                'value' => 'Flight',
                'key' => 'flight_status',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 41,
                'value' => 'Non-Flight',
                'key' => 'flight_status',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 42,
                'value' => 'Palembang',
                'key' => 'home_base',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 43,
                'value' => 'Jambi',
                'key' => 'home_base',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 44,
                'value' => 'Jakarta',
                'key' => 'home_base',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 45,
                'value' => 'Palembang 07:30',
                'key' => 'crew_change_schedule',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 46,
                'value' => 'Palembang 08:30',
                'key' => 'crew_change_schedule',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 47,
                'value' => 'Jambi 11:00',
                'key' => 'crew_change_schedule',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 48,
                'value' => 'Grissik 05:30',
                'key' => 'crew_change_schedule',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 49,
                'value' => 'Grissik 08:30',
                'key' => 'crew_change_schedule',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 50,
                'value' => 'Suban 05:15',
                'key' => 'crew_change_schedule',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 51,
                'value' => 'Suban 05:30',
                'key' => 'crew_change_schedule',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 52,
                'value' => 'Dayung 05:30',
                'key' => 'crew_change_schedule',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 53,
                'value' => 'Grissik (Simpang Gas) 07:30',
                'key' => 'crew_change_schedule',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // Insert data into settings table
        DB::table('itrac_utility')->insert($settings);
    }
}
