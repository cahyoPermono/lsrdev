<?php

namespace App\Console\Commands;

use App\Models\AuthorizationUser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExportAuthorization extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:export-authorization';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export authorization_user to csv';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $results = AuthorizationUser::join('app_modules', 'app_modules.id', '=', 'authorization_users.modules_id')
            ->select('authorization_users.email', DB::raw('string_agg(app_modules.name, \', \') as modules'))
            ->groupBy('authorization_users.email')
            ->orderBy('authorization_users.email', 'asc')
            ->get();
        
        $now = now()->format('Y-m-d_H-i-s');
        $fileName = "authorization_report-{$now}.csv";
        $filePath = public_path('exports/' . $fileName); // Save to public/exports directory
        
        // Create the directory if it doesn't exist
        if (!file_exists(dirname($filePath))) {
            mkdir(dirname($filePath), 0755, true);
        }
        
        // Open file in write mode
        $file = fopen($filePath, 'w');
        
        // Add CSV headers with semicolon delimiter
        fputcsv($file, ['Email', 'Modules'], ';');
        
        // Write data to CSV using semicolon delimiter
        foreach ($results as $result) {
            fputcsv($file, [$result->email, $result->modules], ';');
        }
        
        // Close the file
        fclose($file);
    }
}