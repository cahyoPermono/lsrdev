<?php

namespace App\Console\Commands\UseCase2\Summary;

use App\Helpers\MedcoRestful;
use App\Helpers\Url;
use App\Models\UseCase2\UseCase2FieldSummary;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertFieldSummaryData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'use-case-2:insert-field-summary-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Use Case 2 - Insert summary field Data [4]';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $itemData = MedcoRestful::fetchData(
            url: Url::GetSummaryFieldDashboardData
        );
        if ($itemData) {
            DB::transaction(function () use ($itemData) {

                UseCase2FieldSummary::truncate();
                $itemData = collect($itemData)
                    ->map(function ($row) {
                        $gross = @$row['gross'];
                        $nett = @$row['nett'];
                        return [
                            'created_at' => now(),
                            'date' => @$row['date'],
                            'asset_code' => @$row['block_code'],
                            'block_code' => @$row['field_name'],
                            'code' => '',
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
                UseCase2FieldSummary::insert($itemData);
            });
        }
    }
}
