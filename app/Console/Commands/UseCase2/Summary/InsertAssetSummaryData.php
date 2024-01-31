<?php

namespace App\Console\Commands\UseCase2\Summary;

use App\Helpers\MedcoRestful;
use App\Helpers\Url;
use App\Models\UseCase2\UseCase2AssetSummary;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertAssetSummaryData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'use-case-2:insert-asset-summary-data';

    /**
     * The console command description.
     *
     * @var string
     */

     protected $description = 'Use Case 2 - Insert summary asset Data [2]';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $itemData = MedcoRestful::fetchData(
            url: Url::GetSummaryAssetDashboardData
        );
        if ($itemData) {
            DB::transaction(function () use ($itemData) {

                UseCase2AssetSummary::truncate();
                $itemData = collect($itemData)
                    ->map(function ($row) {
                        $gross = @$row['gross'];
                        $nett = @$row['nett'];
                        return [
                            'created_at' => now(),
                            'date' => @$row['date'],
                            'company_code' => @$row['asset_kind'],
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
                UseCase2AssetSummary::insert($itemData);
            });
        }
    }
}
