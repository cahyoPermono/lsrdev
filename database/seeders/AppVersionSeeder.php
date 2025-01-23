<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppVersionSeeder extends Seeder
{
    public function run()
    {
        // Insert new records
        DB::table('app_versions')->insert([
            [
                'id' => 1,
                'android_version' => '1.1.0',
                'ios_version' => '1.1.0',
                'download_url' => 'https://mmap.medcoenergi.com/338w62qi19r0/',
                'text_template' => 'SmartX version $version is now available!',
                'created_at' => '2024-11-19 11:07:14',
                'updated_at' => '2025-01-08 13:36:18',
                'popup_title' => 'New Version Avalable',
                'button_text' => 'Download',
            ],
        ]);
    }
}
