<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ITracPersonnelCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'code' => 'foa',
                'name' => 'FOA',
                'days' => '1',
                'created_at' => '2025-06-05 14:24:00',
                'updated_at' => '2025-06-05 14:24:00',
            ],
            [
                'id' => 2,
                'code' => 'contractor_non_foa',
                'name' => 'Contractor Non-FOA',
                'days' => '2;3;4;5',
                'created_at' => '2025-06-05 14:24:00',
                'updated_at' => '2025-06-05 14:24:00',
            ],
            [
                'id' => 3,
                'code' => 'medco_employee',
                'name' => 'Medco Employee',
                'days' => '2;3;4;5',
                'created_at' => '2025-06-05 14:24:00',
                'updated_at' => '2025-06-05 14:24:00',
            ],
            [
                'id' => 4,
                'code' => 'tpc_ops',
                'name' => 'TPS Ops',
                'days' => '2;3;4;5',
                'created_at' => '2025-06-05 14:24:00',
                'updated_at' => '2025-06-05 14:24:00',
            ],
            [
                'id' => 5,
                'code' => 'tpc_non_ops',
                'name' => 'TPS Non-Ops',
                'days' => '2;3;4;5',
                'created_at' => '2025-06-05 14:24:00',
                'updated_at' => '2025-06-05 14:24:00',
            ],
            [
                'id' => 6,
                'code' => 'security_non_grissik_rawa',
                'name' => 'Security (Non Grissik-Rawa)',
                'days' => '6',
                'created_at' => '2025-06-05 14:24:00',
                'updated_at' => '2025-06-05 14:24:00',
            ],
        ];

        // Insert data into settings table
        DB::table('itrac_personnel_category')->insert($data);
    }
}
