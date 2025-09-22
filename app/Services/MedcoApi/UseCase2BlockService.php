<?php

namespace App\Services\MedcoApi;

use Carbon\CarbonPeriod;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Services\UseCase2\UseCase2BlockDataService;

class UseCase2BlockService
{
     public function __construct(
          private $useCase2BlockDataService = new UseCase2BlockDataService
     ) {}

     public function summary($code)
     {
          $data = $this->useCase2BlockDataService->findSummary($code);
          $gross = $data ? $data->gross : [];
          $nett = $data ? $data->net : [];
          return [
               "total" => [
                    "net" => @$nett['total'] ?: 0,
                    "gross" => @$gross['total'] ?: 0,
               ],
               "day_variance" => [
                    "net" => [
                         "delta" => @$nett['day_variance_delta'] ?: 0,
                         "percent" => @$nett["day_variance_percent"] ?: 0,
                    ],
                    "gross" => [
                         "delta" => @$gross['day_variance_delta'] ?: 0,
                         "percent" => @$gross["day_variance_percent"] ?: 0,
                    ]
               ],
               "ytd_production" => [
                    "net" => @$nett['ytd_production'] ?: 0,
                    "gross" => @$gross['ytd_production'] ?: 0,
               ],
          ];
     }

     public function chart($code, $filter, $type)
     {
          $period = @$filter['period'];
          $dateRange = getDateRange($period);
          $startDate = $dateRange['start'];
          $endDate   = $dateRange['end'];

          return $this->useCase2BlockDataService->findAllChartByDateRangeAndType($startDate, $endDate, $code, $type)->map(function ($row) {
               $date = Carbon::parse($row->date_label);
               $budget = [
                    'net' => (float) $row->budget_net,
                    'gross' => (float) $row->budget_gross,
               ];
               $actual = [
                    'net' => (float) $row->actual_net,
                    'gross' => (float) $row->actual_gross,
               ];
               $outlook = [
                    'net' => (float) $row->outlook_net,
                    'gross' => (float) $row->outlook_gross,
               ];
               return [
                    'date' => $date->format('Y-m-d'),
                    'date_label' => $date->format('d M Y'),
                    'month' => $date->format('M'),
                    'year' => $date->format('Y'),
                    'day' => $date->format('d'),
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
          return $this->useCase2BlockDataService->findAllByDateAndType($date, $code, 'production')->map(fn($row) => [
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
          return $this->useCase2BlockDataService->findAllByDateAndType($date, $code, 'sales')->map(fn($row) => [
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
