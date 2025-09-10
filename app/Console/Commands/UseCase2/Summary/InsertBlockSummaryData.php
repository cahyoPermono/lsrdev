<?php

namespace App\Console\Commands\UseCase2\Summary;

use App\Helpers\MedcoRestful;
use App\Helpers\Url;
use App\Models\UseCase2\UseCase2BlockSummary;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertBlockSummaryData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'use-case-2:insert-block-summary-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Use Case 2 - Insert summary block Data [3]';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        print $this->description . PHP_EOL;
        $itemData = MedcoRestful::fetchData(
            url: Url::GetSummaryBlockDashboardData, timeout:600
        );
        if ($itemData) {
            DB::transaction(function () use ($itemData) {

                UseCase2BlockSummary::truncate();
                $itemData = collect($itemData)
                    ->map(function ($row) {
                        $gross = @$row['gross'];
                        $nett = @$row['nett'];
                        return [
                            'created_at' => now(),
                            'date' => @$row['date'],
                            'asset_code' => @$row['block_name'],
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
                UseCase2BlockSummary::insert($itemData);
            });
        }
    }
}
