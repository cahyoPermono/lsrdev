<?php

namespace App\Console\Commands\UseCase2;

use App\Helpers\Url;
use Illuminate\Support\Str;
use App\Helpers\MedcoRestful;
use App\Models\UseCase2\UseCase2AssetData;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertAssetDashboardData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'use-case-2:insert-asset-dashboard-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Use Case 2 - Insert Production & Sales Asset Data [2]';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $this->fetchAndInsertData(
            url: Url::GetProductionAssetDashboardData,
            type: 'production'
        );

        $this->fetchAndInsertData(
            url: Url::GetSalesAssetDashboardData,
            type: 'sales'
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
                        $name = @$row['asset_kind'];
                        $code = @$row['block_code'] ?: Str::slug(strtoupper($name));
                        $gas = @$row['gas'];
                        $oil = @$row['oil'];
                        return [
                            'created_at' => now(),
                            'type' => $type,
                            'date' => @$row['date'],
                            'name' => $name,
                            'code' => $code,
                            'productivity_index' => @$row['productivity_index'] ?: 1,
                            'country_code' => @$row['country_code'],
                            'gas_net' => json_encode([
                                'delta' => @$gas['nett']['today'],
                                'percent' => @$gas['nett']['percent']
                            ]),
                            'gas_gross' => json_encode([
                                'delta' => @$gas['gross']['today'],
                                'percent' => @$gas['gross']['percent']
                            ]),
                            'oil_net' => json_encode([
                                'delta' => @$oil['nett']['today'],
                                'percent' => @$oil['nett']['percent']
                            ]),
                            'oil_gross' => json_encode([
                                'delta' => @$oil['nett']['today'],
                                'percent' => @$oil['nett']['percent']
                            ]),
                        ];
                    })
                    ->toArray();
                UseCase2AssetData::insert($itemData);
            });
        }
    }
    private function deleteUseCase2Data($date, $type)
    {
        return UseCase2AssetData::query()
            ->where('date', $date)
            ->where('type', $type)
            ->delete();
    }
}
