<?php

namespace App\Console\Commands\UseCase2\Summary;

use App\Helpers\MedcoRestful;
use App\Helpers\Url;
use App\Models\UseCase2\UseCase2CompanySummary;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertCompanySummaryData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'use-case-2:insert-company-summary-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Use Case 2 - Insert summary Company Data [1]';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $itemData = MedcoRestful::fetchData(
            url: Url::GetSummaryCompanyDashboardData
        );
        if ($itemData) {
            DB::transaction(function () use ($itemData) {

                UseCase2CompanySummary::truncate();
                $itemData = collect($itemData)
                    ->map(function ($row) {
                        $gross = @$row['gross'];
                        $nett = @$row['nett'];
                        return [
                            'created_at' => now(),
                            'date' => @$row['date'],
                            'gross' => json_encode([
                                'total' => @$gross['total_today'],
                                'day_variance_delta' => @$gross['total_delta'],
                                'day_variance_percent' => @$gross['total_percent'],
                                'ytd_production' => @$gross['total_ytd'],
                            ]),
                            'net' => json_encode([
                                'total' => @$nett['total_today'],
                                'day_variance_delta' => @$nett['total_delta'],
                                'day_variance_percent' => @$nett['total_percent'],
                                'ytd_production' => @$nett['total_ytd'],
                            ]),
                        ];
                    })
                    ->toArray();
                UseCase2CompanySummary::insert($itemData);
            });
        }
    }
}
