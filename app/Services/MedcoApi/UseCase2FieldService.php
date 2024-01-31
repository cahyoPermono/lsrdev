<?php

namespace App\Services\MedcoApi;

use Carbon\CarbonPeriod;
use Illuminate\Support\Str;
use App\Services\UseCase2\UseCase2FieldDataService;

class UseCase2FieldService
{
     public function __construct(
          private $useCase2FieldDataService = new UseCase2FieldDataService
     ) {
     }

     public function summary($code)
     {
          $data = $this->useCase2FieldDataService->findSummary($code);
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

     public function gasChart($code, $filter)
     {
          $period = @$filter['period'] ?: 'YTD';
          $currentDate = date('Y-m-d');
          $startDate = $period === '360_DAYS' ? now()->subDays(360)->startOfDay() : date('Y-01-01');
          $periods = CarbonPeriod::create($startDate, $currentDate)->month();

          $result = [];
          foreach ($periods as $date) {
               $result[] = [
                    'date' => $date->format('Y-m'),
                    'date_label' => $date->format('M Y'),
                    'month' => $date->format('M'),
                    'year' => $date->format('Y'),
                    'items' => [
                         [
                              'label' => "Budget",
                              'slug' => 'budget',
                              'value' => [
                                   "net" => rand(2_000_000, 10_000_000),
                                   "gross" => rand(2_000_000, 10_000_000),
                              ],
                              "percent" => [
                                   "net" => rand(2, 99),
                                   "gross" => rand(1, 80),
                              ]
                         ],
                         [
                              'label' => "Actual",
                              'slug' => 'actual',
                              'value' => [
                                   "net" => rand(2_000_000, 10_000_000),
                                   "gross" => rand(2_000_000, 10_000_000),
                              ],
                              "percent" => [
                                   "net" => rand(2, 99),
                                   "gross" => rand(1, 80),
                              ]
                         ],
                         [
                              'label' => "Outlook",
                              'slug' => 'outlook',
                              'value' => [
                                   "net" => rand(2_000_000, 10_000_000),
                                   "gross" => rand(2_000_000, 10_000_000),
                              ],
                              "percent" => [
                                   "net" => rand(2, 99),
                                   "gross" => rand(1, 80),
                              ]
                         ]
                    ]
               ];
          }
          return $result;
     }

     public function oilChart($code, $filter)
     {
          $period = @$filter['period'] ?: 'YTD';
          $currentDate = date('Y-m-d');
          $startDate = $period === '360_DAYS' ? now()->subDays(360)->startOfDay() : date('Y-01-01');
          $periods = CarbonPeriod::create($startDate, $currentDate)->month();

          $result = [];
          foreach ($periods as $date) {
               $result[] = [
                    'date' => $date->format('Y-m'),
                    'date_label' => $date->format('M Y'),
                    'month' => $date->format('M'),
                    'year' => $date->format('Y'),
                    'items' => [
                         [
                              'label' => "Budget",
                              'slug' => 'budget',
                              'value' => [
                                   "net" => rand(2_000_000, 10_000_000),
                                   "gross" => rand(2_000_000, 10_000_000),
                              ],
                              "percent" => [
                                   "net" => rand(2, 99),
                                   "gross" => rand(1, 80),
                              ]
                         ],
                         [
                              'label' => "Actual",
                              'slug' => 'actual',
                              'value' => [
                                   "net" => rand(2_000_000, 10_000_000),
                                   "gross" => rand(2_000_000, 10_000_000),
                              ],
                              "percent" => [
                                   "net" => rand(2, 99),
                                   "gross" => rand(1, 80),
                              ]
                         ],
                         [
                              'label' => "Outlook",
                              'slug' => 'outlook',
                              'value' => [
                                   "net" => rand(2_000_000, 10_000_000),
                                   "gross" => rand(2_000_000, 10_000_000),
                              ],
                              "percent" => [
                                   "net" => rand(2, 99),
                                   "gross" => rand(1, 80),
                              ]
                         ]
                    ]
               ];
          }
          return $result;
     }

     public function productionData($code, $limit = 10)
     {
          $date = now()->subDays(1)->format('Y-m-d');
          return $this->useCase2FieldDataService->findAllByDateAndType($date,$code, 'production')->map(fn($row) => [
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
          return [];
     }
}
