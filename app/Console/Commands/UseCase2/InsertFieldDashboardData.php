<?php

namespace App\Console\Commands\UseCase2;

use App\Helpers\Url;
use App\Helpers\MedcoRestful;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\UseCase2\UseCase2FieldData;

class InsertFieldDashboardData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'use-case-2:insert-field-dashboard-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Use Case 2 - Insert Production & Sales Field Data [4]';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $this->fetchAndInsertData(
            url: Url::GetProductionFieldDashboardData,
            type: 'production'
        );
    }

    private function fetchAndInsertData($url, $type)
    {
        $datePeriod = now()->subDays(1)->format('Y-m-d');
        if ($itemData = MedcoRestful::fetchData($url)) {
            DB::transaction(function () use ($itemData, $datePeriod, $type) {

                $this->deleteUseCase2Data($datePeriod, $type);

                $itemData = collect($itemData)
                    ->whereNotNull('well_code')
                    ->map(function ($row) use ($type) {
                        $name = @$row['well_code'];
                        $gas = @$row['gas'];
                        $oil = @$row['oil'];
                        return [
                            'created_at' => now(),
                            'type' => $type,
                            'date' => @$row['date'],
                            'name' => $name,
                            'code' => $name,
                            'asset_code' => @$row['block_name'],
                            'block_code' => @$row['field_name'],
                            'country_code' => '',
                            'gas_net' => json_encode([
                                'delta' => @$gas['nett']['today'],
                                'percent' => @$gas['nett']['delta']
                            ]),
                            'gas_gross' => json_encode([
                                'delta' => @$gas['gross']['today'],
                                'percent' => @$gas['gross']['delta']
                            ]),
                            'oil_net' => json_encode([
                                'delta' => @$oil['nett']['today'],
                                'percent' => @$oil['nett']['delta']
                            ]),
                            'oil_gross' => json_encode([
                                'delta' => @$oil['gross']['today'],
                                'percent' => @$oil['gross']['delta']
                            ]),
                        ];
                    })
                    ->toArray();
                UseCase2FieldData::insert($itemData);
            });
        }
    }
    private function deleteUseCase2Data($date, $type)
    {
        return UseCase2FieldData::query()
            // ->where('date', $date)
            ->where('type', $type)
            ->delete();
    }
}
