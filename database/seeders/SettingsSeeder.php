<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            [
                'id' => 1,
                'uuid' => '634108ca-00a9-4465-b688-35ad54cfab6b',
                'value' => 'ON-DUTY',
                'key' => 'itrac_status',
                'created_at' => '2024-11-20 14:24:00',
                'updated_at' => '2024-11-20 14:24:00',
            ],
            [
                'id' => 2,
                'uuid' => 'd894b390-4fc8-4fd2-9ca8-d6d8d925640e',
                'value' => 'OFF-DUTY',
                'key' => 'itrac_status',
                'created_at' => '2024-11-20 14:24:00',
                'updated_at' => '2024-11-20 14:24:00',
            ],
            [
                'id' => 3,
                'uuid' => '0c024e24-f84d-4cf0-927d-ef477c203607',
                'value' => 'Palembang 07:30',
                'key' => 'itrac_schedule',
                'created_at' => '2024-11-20 14:24:00',
                'updated_at' => '2024-11-20 14:24:00',
            ],
            [
                'id' => 4,
                'uuid' => '1ed3d00f-7a0e-447d-acc6-548a6cca7483',
                'value' => 'Jambi 11:00',
                'key' => 'itrac_schedule',
                'created_at' => '2024-11-20 14:24:00',
                'updated_at' => '2024-11-20 14:24:00',
            ],
            [
                'id' => 5,
                'uuid' => 'bf7cd5ac-a924-42a5-b52f-1e9b82ce821f',
                'value' => 'Grissik 05:30',
                'key' => 'itrac_schedule',
                'created_at' => '2024-11-20 14:24:00',
                'updated_at' => '2024-11-20 14:24:00',
            ],
            [
                'id' => 6,
                'uuid' => '67182121-9099-4000-92d9-120ea2828c5d',
                'value' => 'Grissik 08:30',
                'key' => 'itrac_schedule',
                'created_at' => '2024-11-20 14:24:00',
                'updated_at' => '2024-11-20 14:24:00',
            ],
            [
                'id' => 7,
                'uuid' => '973065d6-e31c-40a3-a4fc-2b3157e3b059',
                'value' => 'Suban 05:30',
                'key' => 'itrac_schedule',
                'created_at' => '2024-11-20 14:24:00',
                'updated_at' => '2024-11-20 14:24:00',
            ],
            [
                'id' => 8,
                'uuid' => '2ddea7f6-45b8-4040-b8e3-2ce47ed51f32',
                'value' => 'Dayung 05:30',
                'key' => 'itrac_schedule',
                'created_at' => '2024-11-20 14:24:00',
                'updated_at' => '2024-11-20 14:24:00',
            ],
            [
                'id' => 9,
                'uuid' => '6ff5b5df-1b80-4002-9929-aa7ff8afd05f',
                'value' => 'Via Grissik',
                'key' => 'itrac_transit_point',
                'created_at' => '2024-11-21 15:00:00',
                'updated_at' => '2024-11-21 15:00:00',
            ],
            [
                'id' => 10,
                'uuid' => '21fc36b1-3712-4ecb-9043-becc950e6c8d',
                'value' => 'Direct to Location',
                'key' => 'itrac_transit_point',
                'created_at' => '2024-11-21 15:00:00',
                'updated_at' => '2024-11-21 15:00:00',
            ],
            [
                'id' => 11,
                'uuid' => '88e06cdf-d5c7-44c5-b670-70a78419d99e',
                'value' => 'false',
                'key' => 'hse_hide_news',
                'created_at' => '2024-12-04 15:00:00',
                'updated_at' => '2024-12-04 15:00:00',
            ],
            [
                'id' => 12,
                'uuid' => '0647ec13-7ee6-4fc1-b20f-dd2a219ee3c9',
                'value' => 'false',
                'key' => 'hse_hide_poster',
                'created_at' => '2024-12-04 15:00:00',
                'updated_at' => '2024-12-04 15:00:00',
            ],
            [
                'id' => 13,
                'uuid' => '327f5090-a4a8-416f-8cee-d2112cecfd40',
                'value' => 'auto',
                'key' => 'hse_hide_lesson',
                'created_at' => '2024-12-04 15:00:00',
                'updated_at' => '2024-12-04 15:00:00',
            ]
        ];

        // Insert data into settings table
        DB::table('settings')->insert($settings);
    }
}
