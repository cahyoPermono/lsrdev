<?php

namespace App\Services\MedcoApi;

use Carbon\CarbonPeriod;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Services\UseCase2\UseCase2AssetDataService;


class UseCase2AssetsService
{
     public function __construct(
          private $useCase2AssetDataService = new UseCase2AssetDataService
     ) {
     }

     public function summary($code)
     {
          return [
               "total" => [
                    "net" => rand(2_000_000, 10_000_000),
                    "gross" => rand(2_000_000, 10_000_000),
               ],
               "day_variance" => [
                    "net" => [
                         "delta" => rand(2_000_000, 10_000_000),
                         "percent" => rand(0, 100)
                    ],
                    "gross" => [
                         "delta" => rand(2_000_000, 10_000_000),
                         "percent" => rand(0, 100)
                    ]
               ],
               "ytd_production" => [
                    "net" => rand(2_000_000, 10_000_000),
                    "gross" => rand(2_000_000, 10_000_000),
               ]
          ];
     }

     public function gasChart($code, $filter)
     {
          $period = @$filter['period'] ?: 'YTD';
          $endDate = date('Y-m-d');
          $startDate = $period === '360_DAYS' ? now()->subDays(360)->startOfDay() : date('Y-01-01');

          return $this->useCase2AssetDataService->findAllChartByDateRangeAndType($startDate, $endDate, $code, 'gas')->map(function ($row) {
               $date = Carbon::parse($row->date);
               $budget = [
                    'net' => (double) $row->budget_net,
                    'gross' => (double) $row->budget_gross,
               ];
               $actual = [
                    'net' => (double) $row->actual_net,
                    'gross' => (double) $row->actual_gross,
               ];
               $outlook = [
                    'net' => (double) $row->outlook_net,
                    'gross' => (double) $row->outlook_gross,
               ];
               return [
                    'date' => $date->format('Y-m'),
                    'date_label' => $date->format('M Y'),
                    'month' => $date->format('M'),
                    'year' => $date->format('Y'),
                    'items' => [
                         [
                              'label' => "Budget",
                              'slug' => 'budget',
                              'value' => $budget,
                              "percent" => $budget
                         ],
                         [
                              'label' => "Actual",
                              'slug' => 'actual',
                              'value' => $actual,
                              "percent" => $actual
                         ],
                         [
                              'label' => "Outlook",
                              'slug' => 'outlook',
                              'value' => $outlook,
                              "percent" => $outlook
                         ]
                    ]
               ];
          });
     }

     public function oilChart($code, $filter)
     {
          $period = @$filter['period'] ?: 'YTD';
          $endDate = date('Y-m-d');
          $startDate = $period === '360_DAYS' ? now()->subDays(360)->startOfDay() : date('Y-01-01');

          return $this->useCase2AssetDataService->findAllChartByDateRangeAndType($startDate, $endDate, $code, 'oil')->map(function ($row) {
               $date = Carbon::parse($row->date);
               $budget = [
                    'net' => (double) $row->budget_net,
                    'gross' => (double) $row->budget_gross,
               ];
               $actual = [
                    'net' => (double) $row->actual_net,
                    'gross' => (double) $row->actual_gross,
               ];
               $outlook = [
                    'net' => (double) $row->outlook_net,
                    'gross' => (double) $row->outlook_gross,
               ];
               return [
                    'date' => $date->format('Y-m'),
                    'date_label' => $date->format('M Y'),
                    'month' => $date->format('M'),
                    'year' => $date->format('Y'),
                    'items' => [
                         [
                              'label' => "Budget",
                              'slug' => 'budget',
                              'value' => $budget,
                              "percent" => $budget
                         ],
                         [
                              'label' => "Actual",
                              'slug' => 'actual',
                              'value' => $actual,
                              "percent" => $actual
                         ],
                         [
                              'label' => "Outlook",
                              'slug' => 'outlook',
                              'value' => $outlook,
                              "percent" => $outlook
                         ]
                    ]
               ];
          });
     }

     public function productionData($code, $limit = 10)
     {
          $date = now()->subDays(1)->format('Y-m-d');
          return $this->useCase2AssetDataService->findAllByDateAndType($date, $code, 'production')->map(fn($row) => [
               'code' => $row->code,
               'name' => $row->name,
               'gas' => [
                    "net" => $row->gas_net,
                    "gross" => $row->gas_gross
               ],
               'oil' => [
                    "net" => $row->oil_net,
                    "gross" => $row->oil_gross
               ],
          ]);
     }

     public function salesData($code, $limit = 10)
     {
          $date = now()->subDays(1)->format('Y-m-d');
          return $this->useCase2AssetDataService->findAllByDateAndType($date, $code, 'sales')->map(fn($row) => [
               'code' => $row->code,
               'name' => $row->name,
               'gas' => [
                    "net" => $row->gas_net,
                    "gross" => $row->gas_gross
               ],
               'oil' => [
                    "net" => $row->oil_net,
                    "gross" => $row->oil_gross
               ],
          ]);
     }
}
