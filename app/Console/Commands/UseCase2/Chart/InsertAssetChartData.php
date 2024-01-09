<?php

namespace App\Console\Commands\UseCase2\Chart;

use App\Helpers\Url;
use App\Helpers\MedcoRestful;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\UseCase2\UseCase2AssetChartData;

class InsertAssetChartData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'use-case-2:insert-asset-chart-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Use Case 2 - Insert Chart Asset Data [2]';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->fetchAndInsertData(
            url : Url::GetChartAssetGasData,
            type : 'gas'
        );

        $this->fetchAndInsertData(
            url : Url::GetChartAssetOilData,
            type : 'oil'
        );
    }

    private function fetchAndInsertData($url, $type)
    {
        $datePeriod = now()->subDays(1)->format('Y-m-d');
        if ($itemData = MedcoRestful::fetchData($url)) {
            DB::transaction(function () use ($itemData, $datePeriod, $type) {
                $this->deleteUseCase2Data($datePeriod, $type);
                $itemData = collect($itemData)
                    ->map(function ($row) use ($type) {
                        $items = @$row['items'];
                        $actual = @$items['actual'];
                        $budget = @$items['budget'];
                        $outlook = @$items['outlook'];
                        return [
                            'created_at' => now(),
                            'type' => $type,
                            'company_code' => @$row['asset_kind'],
                            'date' => @$row['date'],
                            'actual' => json_encode([
                                'net' => @$actual['net'],
                                'gross' => @$actual['gross']
                            ]),
                            'budget' => json_encode([
                                'net' => @$budget['net'],
                                'gross' => @$budget['gross']
                            ]),
                            'outlook' => json_encode([
                                'net' => @$outlook['net'],
                                'gross' => @$outlook['gross']
                            ]),
                        ];
                    })
                    ->toArray();
                UseCase2AssetChartData::insert($itemData);
            });
        }
    }


    private function deleteUseCase2Data($date, $type)
    {
        return UseCase2AssetChartData::query()
            ->where('date', $date)
            ->where('type', $type)
            ->delete();
    }
}
