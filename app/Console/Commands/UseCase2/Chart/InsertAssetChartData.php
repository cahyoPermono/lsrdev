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
            url: Url::GetChartAssetGasData,
            type: 'gas'
        );

        $this->fetchAndInsertData(
            url: Url::GetChartAssetOilData,
            type: 'oil'
        );
    }

    private function fetchAndInsertData($url, $type)
    {
        if ($itemData = MedcoRestful::fetchData($url)) {
            DB::transaction(function () use ($itemData, $type) {
                $this->deleteUseCase2Data($type);

                $items = collect($itemData)->chunk(200);
                foreach ($items as $data) {
                    $itemData = $data->map(function ($row) use ($type) {
                        $items = @$row['items'];
                        $actual = @$items['actual'];
                        $budget = @$items['budget'];
                        $outlook = @$items['outlook'];
                        $date = @$row['date'];
                        return [
                            'created_at' => now(),
                            'type' => $type,
                            'company_code' => @$row['asset_kind'],
                            'date' => $date,
                            'date_label' => date('Y-m',strtotime($date)),
                            'actual_net' => (double) @$actual['nett'],
                            'actual_gross' => (double) @$actual['gross'],
                            'budget_net' => (double) @$budget['nett'],
                            'budget_gross' => (double) @$budget['gross'],
                            'outlook_net' => (double) @$outlook['nett'],
                            'outlook_gross' => (double) @$outlook['gross'],
                        ];
                    })
                        ->toArray();
                    UseCase2AssetChartData::insert($itemData);
                }

            });
        }
    }


    private function deleteUseCase2Data($type)
    {
        return UseCase2AssetChartData::query()
            ->where('type', $type)
            ->delete();
    }
}
