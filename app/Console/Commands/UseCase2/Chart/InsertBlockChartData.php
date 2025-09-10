<?php

namespace App\Console\Commands\UseCase2\Chart;

use App\Helpers\Url;
use App\Helpers\MedcoRestful;
use App\Models\UseCase2\UseCase2BlockChartData;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertBlockChartData extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'use-case-2:insert-block-chart-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Use Case 2 - Insert Chart Block Data [3]';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        print $this->description . PHP_EOL;
        $this->fetchAndInsertData(
            url: Url::GetChartBlockGasData,
            type: 'gas'
        );

        $this->fetchAndInsertData(
            url: Url::GetChartBlockOilData,
            type: 'oil'
        );
    }

    private function fetchAndInsertData($url, $type)
    {
        if ($itemData = MedcoRestful::fetchData($url, timeout:600)) {
            DB::transaction(function () use ($itemData, $type) {
                $this->deleteUseCase2Data($type);

                $items = collect($itemData)->chunk(200);
                foreach ($items as $data) {
                    $itemData = $data->map(function ($row) use ($type) {
                            $items = @$row['items'];
                            $actual = @$items['actual'];
                            $budget = @$items['budget'];
                            $outlook = @$items['outlook'];
                            $wpnb = @$items['wpnb'];
                            $apbn = @$items['apbn'];
                            $date = @$row['date'];
                            return [
                                'created_at' => now(),
                                'type' => $type,
                                'asset_kind' => @$row['asset_kind'],
                                'block_name' => @$row['block_name'],
                                'date' => $date,
                                'actual_net' => (double) @$actual['nett'],
                                'actual_gross' => (double) @$actual['gross'],
                                'budget_net' => (double) @$budget['nett'],
                                'budget_gross' => (double) @$budget['gross'],
                                'outlook_net' => (double) @$outlook['nett'],
                                'outlook_gross' => (double) @$outlook['gross'],
                                'wpnb_gross' => (double) @$wpnb['gross'],
                                'wpnb_net' => (double) @$wpnb['nett'],
                                'apbn_gross' => (double) @$apbn['gross'],
                                'apbn_net' => (double) @$apbn['nett']
                            ];
                        })
                        ->toArray();
                    UseCase2BlockChartData::insert($itemData);
                }
            });
        }
    }


    private function deleteUseCase2Data($type)
    {
        return UseCase2BlockChartData::query()
            ->where('type', $type)
            ->delete();
    }
}
