<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorizationUserSeeder extends Seeder
{
    public function run()
    {
        // Check if records already exist to avoid duplicates
        $existingRecord1 = DB::table('authorization_users')
            ->where('email', 'medcoweb.uat1@medcoenergi.com')
            ->where('modules_id', 10)
            ->first();

        $existingRecord2 = DB::table('authorization_users')
            ->where('email', 'medcoweb.uat1@medcoenergi.com')
            ->where('modules_id', 19)
            ->first();

        // Insert records only if they don't exist
        if (!$existingRecord1) {
            DB::table('authorization_users')->insert([
                'id' => 4, // Using ID 4 since 1, 2, 3 are already taken
                'uuid' => '7666dce1-eeab-4a69-8778-10267eaf251a',
                'email' => 'medcoweb.uat1@medcoenergi.com',
                'modules_id' => 10,
                'created_at' => '2025-10-06T07:37:22.000Z',
                'updated_at' => '2025-10-06T07:37:22.000Z'
            ]);
        }

        if (!$existingRecord2) {
            DB::table('authorization_users')->insert([
                'id' => 5, // Using ID 5 since 1, 2, 3, 4 are already taken
                'uuid' => '7666dce1-eeab-4a69-8778-10269eaf251a',
                'email' => 'medcoweb.uat1@medcoenergi.com',
                'modules_id' => 19,
                'created_at' => '2025-10-06T07:37:22.000Z',
                'updated_at' => '2025-10-06T07:37:22.000Z'
            ]);
        }
    }
}
