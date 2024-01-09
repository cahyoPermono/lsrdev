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
        $this->fetchAndInsertData(
            url : Url::GetChartBlockGasData,
            type : 'gas'
        );

        $this->fetchAndInsertData(
            url : Url::GetChartBlockOilData,
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
                            'asset_code' => @$row['block_name'],
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
                UseCase2BlockChartData::insert($itemData);
            });
        }
    }


    private function deleteUseCase2Data($date, $type)
    {
        return UseCase2BlockChartData::query()
            ->where('date', $date)
            ->where('type', $type)
            ->delete();
    }
}
