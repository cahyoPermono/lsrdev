<?php

namespace App\Console\Commands\UseCase2\Chart;

use App\Models\UseCase2\UseCase2FieldChartData;
use Illuminate\Console\Command;
use App\Helpers\Url;
use App\Helpers\MedcoRestful;
use App\Models\UseCase2\UseCase2BlockChartData;
use Illuminate\Support\Facades\DB;


class InsertFieldChartData extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'use-case-2:insert-field-chart-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Use Case 2 - Insert Chart Field Data [3]';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        print $this->description . PHP_EOL;
        ini_set('memory_limit', '1G');
        
        $this->fetchAndInsertData(
            url: Url::GetChartFieldGasData,
            type: 'gas'
        );

        $this->fetchAndInsertData(
            url: Url::GetChartFieldOilData,
            type: 'oil'
        );
    }

    private function fetchAndInsertData($url, $type)
    {
        if ($itemData = MedcoRestful::fetchData($url, timeout: 600)) {
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
                                'block_code' => @$row['field_name'],
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
                    UseCase2FieldChartData::insert($itemData);
                }
            });
        }
    }


    private function deleteUseCase2Data($type)
    {
        return UseCase2FieldChartData::query()
            ->where('type', $type)
            ->delete();
    }
}

