<?php

namespace App\Services\MedcoApi;

use Carbon\CarbonPeriod;
use Illuminate\Support\Str;

class UseCase2BlockService
{
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

     public function gasChart($code,$filter)
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

     public function oilChart($code,$filter)
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

     public function productionData($code,$limit = 10)
     {
          $labels = ['Block A', 'Dayung', 'Sumpal', 'Rawa Letang', 'Gelam'];

          return collect($labels)->map(fn($label) => [
               'code' => Str::slug($label),
               'name' => $label,
               'gas' => [
                    "net" => [
                         "delta" => rand(2_000_000, 10_000_000),
                         "percent" => rand(0, 100)
                    ],
                    "gross" => [
                         "delta" => rand(2_000_000, 10_000_000),
                         "percent" => rand(0, 100)
                    ]
               ],
               'oil' => [
                    "net" => [
                         "delta" => rand(2_000_000, 10_000_000),
                         "percent" => rand(0, 100)
                    ],
                    "gross" => [
                         "delta" => rand(2_000_000, 10_000_000),
                         "percent" => rand(0, 100)
                    ]
               ],
          ]);
     }

     public function salesData($code,$limit = 10)
     {
          $labels = ['Block A', 'Dayung', 'Sumpal', 'Rawa Letang', 'Gelam'];

          return collect($labels)->map(fn($label) => [
               'code' => Str::slug($label),
               'name' => $label,
               'gas' => [
                    "net" => [
                         "delta" => rand(2_000_000, 10_000_000),
                         "percent" => rand(0, 100)
                    ],
                    "gross" => [
                         "delta" => rand(2_000_000, 10_000_000),
                         "percent" => rand(0, 100)
                    ]
               ],
               'oil' => [
                    "net" => [
                         "delta" => rand(2_000_000, 10_000_000),
                         "percent" => rand(0, 100)
                    ],
                    "gross" => [
                         "delta" => rand(2_000_000, 10_000_000),
                         "percent" => rand(0, 100)
                    ]
               ],
          ]);
     }
}
