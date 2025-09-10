<?php

namespace App\Console\Commands\UseCase2\Summary;

use App\Helpers\MedcoRestful;
use App\Helpers\Url;
use App\Models\UseCase2\UseCase2CompanyYtdProductionBreakdown;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertCompanyProductionBreakdownData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'use-case-2:insert-company-production-breakdown-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Use Case 2 - Insert production breakdown Company Data [1]';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        print $this->description . PHP_EOL;
        $itemData = MedcoRestful::fetchData(
            url: Url::GetYtdVsBudgetCompanyData, timeout:600
        );
        if ($itemData) {
            UseCase2CompanyYtdProductionBreakdown::truncate();
    
            foreach ($itemData as $entry) {
                $date = $entry['date'];
                $countryCode = $entry['country_code'];
                foreach (['gas', 'oil', 'total'] as $type) {
                    foreach (['gross', 'nett'] as $workingInterest) {
                        $values = $entry[$type][$workingInterest] ?? null;

                        if ($values) {
                            $records[] = [
                                'date' => $date,
                                'country_code' => $countryCode,
                                'type' => $type,
                                'working_interest' => $workingInterest,
                                'ytd_production' => $values['ytd'] ?? null,
                                'budget' => $values['budget'] ?? null,
                                'delta' => $values['delta'] ?? null,
                                'percent' => $values['delta_percent'] ?? null,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ];
                        }
                    }
                }
            }

            // Bulk insert
            UseCase2CompanyYtdProductionBreakdown::insert($records);    
        }
    }
}
