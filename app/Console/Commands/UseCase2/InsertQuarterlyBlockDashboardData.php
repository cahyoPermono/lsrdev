<?php

namespace App\Console\Commands\UseCase2;

use App\Helpers\Url;
use App\Helpers\MedcoRestful;
use App\Models\UseCase2\UseCase2BlockQuarterlyData;
use App\Models\UseCase2\UseCase2CompanyQuarterlyData;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertQuarterlyBlockDashboardData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'use-case-2:insert-quarterly-block-dashboard-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Use Case 2 - Insert Quarterly Production Block Data [3]';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        print $this->description;
        $this->fetchAndInsertData(
            url: Url::GetQuarterlyProductionBlockDashboardData,
            type: 'production'
        );
    }

    private function fetchAndInsertData($url, $type)
    {
        if ($itemData = MedcoRestful::fetchData($url, timeout:600)) {
            UseCase2BlockQuarterlyData::truncate();
            // Fields, for Block-level page
            DB::transaction(function () use ($itemData, $type) {

                $itemData = collect($itemData)
                    ->whereNotNull('field_name')
                    ->map(function ($row) use ($type) {
                        $gas = @$row['gas'];
                        $oil = @$row['oil'];
                        return [
                            'quarter' => @$row['quarter'],
                            'year' => @$row['year'],
                            'type' => $type,
                            'field_name' => @$row['field_name'],
                            'asset_kind' => @$row['asset_kind'],
                            'block_name' => @$row['block_name'],
                            'country_code' => @$row['country_code'],
                            'gas_net' => json_encode(@$gas['nett']),
                            'gas_gross' => json_encode( @$gas['gross']),
                            'oil_net' => json_encode(@$oil['nett']),
                            'oil_gross' =>json_encode(@$oil['gross']),
                            'created_at' => now()
                        ];
                    })
                    ->toArray();
                UseCase2BlockQuarterlyData::insert($itemData);
            });            
        }

        // Assets, for Company-level page

        DB::transaction(function () use ($itemData, $type) {
            UseCase2CompanyQuarterlyData::truncate();
            $grouped = collect($itemData)
                ->whereNotNull('field_name')
                ->groupBy(function ($row) {
                    return $row['quarter'] . '|' . $row['year'] . '|' . $row['asset_kind'];
                });

            $itemData = $grouped->map(function ($group, $key) use ($type) {
                [$quarter, $year, $assetKind] = explode('|', $key);

                $first = $group->first();

                // Sum fields
                $gasNetCurrent = 0;
                $gasNetPrevious = 0;
                $gasGrossCurrent = 0;
                $gasGrossPrevious = 0;
                $oilNetCurrent = 0;
                $oilNetPrevious = 0;
                $oilGrossCurrent = 0;
                $oilGrossPrevious = 0;

                foreach ($group as $row) {
                    $gas = @$row['gas'] ?? [];
                    $oil = @$row['oil'] ?? [];

                    $gasNetCurrent += @$gas['nett']['current'] ?? 0;
                    $gasNetPrevious += @$gas['nett']['previous'] ?? 0;

                    $gasGrossCurrent += @$gas['gross']['current'] ?? 0;
                    $gasGrossPrevious += @$gas['gross']['previous'] ?? 0;

                    $oilNetCurrent += @$oil['nett']['current'] ?? 0;
                    $oilNetPrevious += @$oil['nett']['previous'] ?? 0;

                    $oilGrossCurrent += @$oil['gross']['current'] ?? 0;
                    $oilGrossPrevious += @$oil['gross']['previous'] ?? 0;
                }

                $buildStat = function ($current, $previous) {
                    $delta = $current - $previous;
                    $percent = $previous != 0 ? round(($delta / $previous) * 100, 2) : null;
                    return [
                        'current' => round($current, 2),
                        'previous' => round($previous, 2),
                        'delta' => round($delta, 2),
                        'percent' => $percent,
                    ];
                };

                return [
                    'quarter' => $quarter,
                    'year' => $year,
                    'type' => $type,
                    'asset_kind' => $assetKind,
                    'country_code' => $first['country_code'],
                    'gas_net' => json_encode($buildStat($gasNetCurrent, $gasNetPrevious)),
                    'gas_gross' => json_encode($buildStat($gasGrossCurrent, $gasGrossPrevious)),
                    'oil_net' => json_encode($buildStat($oilNetCurrent, $oilNetPrevious)),
                    'oil_gross' => json_encode($buildStat($oilGrossCurrent, $oilGrossPrevious)),
                    'created_at' => now(),
                ];
            })->values()->toArray();

             UseCase2CompanyQuarterlyData::insert($itemData);
        });

    }
}