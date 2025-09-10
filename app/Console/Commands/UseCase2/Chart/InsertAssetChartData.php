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
        print $this->description . PHP_EOL;
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

        if ($itemData = MedcoRestful::fetchData($url, timeout:600)) {
            $aggregatedData = DB::table('use_case2_block_chart_data')
            ->select(
                'date',
                'type',
                'asset_kind',
                DB::raw('ROUND(SUM(wpnb_gross)::numeric, 2) as wpnb_gross'),
                DB::raw('ROUND(SUM(wpnb_net)::numeric, 2) as wpnb_net'),
                DB::raw('ROUND(SUM(apbn_gross)::numeric, 2) as apbn_gross'),
                DB::raw('ROUND(SUM(apbn_net)::numeric, 2) as apbn_net')
            )
            ->groupBy('date', 'type', 'asset_kind')
            ->get()
            ->keyBy(function ($item) {
                return "{$item->date}|{$item->type}|{$item->asset_kind}";
            });

            DB::transaction(function () use ($itemData, $type, $aggregatedData) {
                $this->deleteUseCase2Data($type);

                $items = collect($itemData)->chunk(200);
                foreach ($items as $data) {
                    $itemData = $data->map(function ($row) use ($type, $aggregatedData) {
                        $items = @$row['items'];
                        $actual = @$items['actual'];
                        $budget = @$items['budget'];
                        $outlook = @$items['outlook'];
                        $date = @$row['date'];
                        $assetKind = @$row['asset_kind'];

                        $aggKey = "{$date}|{$type}|{$assetKind}";
                        $agg = $aggregatedData[$aggKey] ?? null;

                        return [
                            'created_at' => now(),
                            'type' => $type,
                            'asset_kind' => $assetKind,
                            'date' => $date,
                            'actual_net' => (double) @$actual['nett'],
                            'actual_gross' => (double) @$actual['gross'],
                            'budget_net' => (double) @$budget['nett'],
                            'budget_gross' => (double) @$budget['gross'],
                            'outlook_net' => (double) @$outlook['nett'],
                            'outlook_gross' => (double) @$outlook['gross'],
                            'wpnb_gross' => (double)  @$agg->wpnb_gross  ?? null,
                            'wpnb_net' => (double)  @$agg->wpnb_net  ?? null,
                            'apbn_gross' => (double)  @$agg->apbn_gross  ?? null,
                            'apbn_net' => (double) @$agg->apbn_net  ?? null,                            
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
