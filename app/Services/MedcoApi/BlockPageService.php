<?php

namespace App\Services\MedcoApi;


class BlockPageService 
{
     public function userCaseBlock($assets_id)
     {
          $entries = [
               [
                    "value" => [
                         "net" => rand(500000, 1_000_000),
                         "gross" => rand(500000, 1_000_000),
                    ],
                    "values" => [
                         "net" => rand(0, 1) == 1 ? 1 : -1,
                         "gross" => rand(0, 1) == 1 ? 1 : -1,
                    ],
                    "title" => "MEDC.",
                    "date" => "2023-08-24",
               ],
               [
                    "value" => [
                         "net" => rand(500000, 1_000_000),
                         "gross" => rand(500000, 1_000_000),
                    ],
                    "values" => [
                         "net" => rand(0, 1) == 1 ? 1 : -1,
                         "gross" => rand(0, 1) == 1 ? 1 : -1,
                    ],
                    "title" => "Brent",
                    "date" => "2023-08-24",
               ],
               [
                    "value" => [
                         "net" => rand(500000, 1_000_000),
                         "gross" => rand(500000, 1_000_000),
                    ],
                    "values" => [
                         "net" => rand(0, 1) == 1 ? 1 : -1,
                         "gross" => rand(0, 1) == 1 ? 1 : -1,
                    ],
                    "title" => "CPI",
                    "date" => "2023-08-24",
               ],
          ];

          return $entries;
     }


     public function blockSummaryProduction($assets_id)
     {
          return [
               "total_value" => [
                    "net" => rand(500000, 1_000_000),
                    "gross" => rand(500000, 1_000_000),
               ],
               "items" => [
                    [
                         "title" => "Day Variance",
                         "value" => [
                              "net" => rand(500000, 1_000_000),
                              "gross" => rand(500000, 1_000_000),
                         ],
                         "values" => [
                              "net" => rand(0, 1) == 1 ? 1 : -1,
                              "gross" => rand(0, 1) == 1 ? 1 : -1,
                         ],
                    ],
                    [
                         "title" => "YTD Production",
                         "value" => [
                              "net" => rand(500000, 1_000_000),
                              "gross" => rand(500000, 1_000_000),
                         ],
                         "values" => [
                              "net" => rand(0, 1) == 1 ? 1 : -1,
                              "gross" => rand(0, 1) == 1 ? 1 : -1,
                         ],
                    ],
               ],
          ];
     }

     public function blockChartGas($assets_id, $filter = null)
     {
          $months = [
               "January", "February", "March", "April", "May", "June",
               "July", "August", "September", "October", "November", "December"
          ];

          $data = [];
          $currentMonth = date("F");

          $startMonth = "January";
          $endMonth = "December";

          // Inisialisasi $foundStartMonth
          $foundStartMonth = false;

          if ($filter === 'YTD') {
               $endMonth = $currentMonth;
          } elseif ($filter === '360daysago') {
               // Hitung bulan akhir berdasarkan 360 hari yang lalu
               $endDate = new \DateTime();
               $endDate->sub(new \DateInterval('P360D'));
               $endMonth = $endDate->format('F');

               // Hitung bulan awal sesuai dengan bulan akhir
               $startMonth = $endMonth;
          }

          foreach ($months as $month) {
               if ($month === $startMonth) {
                    $foundStartMonth = true;
               }

               if ($foundStartMonth) {
                    $item = [
                         "month" => $month,
                         "items" => [
                              [
                                   "title" => "Budget",
                                   "value" => [
                                        "net" => rand(500000, 1_000_000),
                                        "gross" => rand(500000, 1_000_000),
                                   ],
                                   "slug" => "budget",
                                   "code" => "1",
                              ],
                              [
                                   "title" => "Actual",
                                   "value" => [
                                        "net" => rand(500000, 1_000_000),
                                        "gross" => rand(500000, 1_000_000),
                                   ],
                                   "slug" => "actual",
                                   "code" => "2",
                              ],
                              [
                                   "title" => "Outlook",
                                   "value" => [
                                        "net" => rand(500000, 1_000_000),
                                        "gross" => rand(500000, 1_000_000),
                                   ],
                                   "slug" => "outlook",
                                   "code" => "3",
                              ]
                         ],
                    ];

                    $data[] = $item;

                    if ($month == $endMonth) {
                         break;
                    }
               }
          }

          return $data;
     }


     public function blockChartOil($assets_id, $filter = null)
     {
          $months = [
               "January", "February", "March", "April", "May", "June",
               "July", "August", "September", "October", "November", "December"
          ];

          $data = [];
          $currentMonth = date("F");

          $startMonth = "January";
          $endMonth = "December";

          // Inisialisasi $foundStartMonth
          $foundStartMonth = false;

          if ($filter === 'YTD') {
               $endMonth = $currentMonth;
          } elseif ($filter === '360daysago') {
               // Hitung bulan akhir berdasarkan 360 hari yang lalu
               $endDate = new \DateTime();
               $endDate->sub(new \DateInterval('P360D'));
               $endMonth = $endDate->format('F');

               // Hitung bulan awal sesuai dengan bulan akhir
               $startMonth = $endMonth;
          }

          foreach ($months as $month) {
               if ($month === $startMonth) {
                    $foundStartMonth = true;
               }

               if ($foundStartMonth) {
                    $item = [
                         "month" => $month,
                         "items" => [
                              [
                                   "title" => "Budget",
                                   "value" => [
                                        "net" => rand(500000, 1_000_000),
                                        "gross" => rand(500000, 1_000_000),
                                   ],
                                   "slug" => "budget",
                                   "code" => "1",
                              ],
                              [
                                   "title" => "Actual",
                                   "value" => [
                                        "net" => rand(500000, 1_000_000),
                                        "gross" => rand(500000, 1_000_000),
                                   ],
                                   "slug" => "actual",
                                   "code" => "2",
                              ],
                              [
                                   "title" => "Outlook",
                                   "value" => [
                                        "net" => rand(500000, 1_000_000),
                                        "gross" => rand(500000, 1_000_000),
                                   ],
                                   "slug" => "outlook",
                                   "code" => "3",
                              ]
                         ],
                    ];

                    $data[] = $item;

                    if ($month == $endMonth) {
                         break;
                    }
               }
          }

          return $data;
     }




     public function blockDataList($assets_id)
     {
          $dataList = [
               [
                    "name" => "Belanak",
                    "gas" => [
                         "value" => [
                              "net" => rand(500000, 1_000_000),
                              "gross" => rand(500000, 1_000_000),
                         ],
                         "values" => [
                              "net" => rand(0, 1) == 1 ? 1 : -1,
                              "gross" => rand(0, 1) == 1 ? 1 : -1,
                         ],
                    ],
                    "oil" => [
                         "value" => [
                              "net" => rand(500000, 1_000_000),
                              "gross" => rand(500000, 1_000_000),
                         ],
                         "values" => [
                              "net" => rand(0, 1) == 1 ? 1 : -1,
                              "gross" => rand(0, 1) == 1 ? 1 : -1,
                         ],
                    ],
               ],
               [
                    "name" => "North Belut",
                    "gas" => [
                         "value" => [
                              "net" => rand(500000, 1_000_000),
                              "gross" => rand(500000, 1_000_000),
                         ],
                         "values" => [
                              "net" => rand(0, 1) == 1 ? 1 : -1,
                              "gross" => rand(0, 1) == 1 ? 1 : -1,
                         ],
                    ],
                    "oil" => [
                         "value" => [
                              "net" => rand(500000, 1_000_000),
                              "gross" => rand(500000, 1_000_000),
                         ],
                         "values" => [
                              "net" => rand(0, 1) == 1 ? 1 : -1,
                              "gross" => rand(0, 1) == 1 ? 1 : -1,
                         ],
                    ],
               ],
               [
                    "name" => "Kerisi",
                    "gas" => [
                         "value" => [
                              "net" => rand(500000, 1_000_000),
                              "gross" => rand(500000, 1_000_000),
                         ],
                         "values" => [
                              "net" => rand(0, 1) == 1 ? 1 : -1,
                              "gross" => rand(0, 1) == 1 ? 1 : -1,
                         ],
                    ],
                    "oil" => [
                         "value" => [
                              "net" => rand(500000, 1_000_000),
                              "gross" => rand(500000, 1_000_000),
                         ],
                         "values" => [
                              "net" => rand(0, 1) == 1 ? 1 : -1,
                              "gross" => rand(0, 1) == 1 ? 1 : -1,
                         ],
                    ],
               ],
               [
                    "name" => "Hang Tuah",
                    "gas" => [
                         "value" => [
                              "net" => rand(500000, 1_000_000),
                              "gross" => rand(500000, 1_000_000),
                         ],
                         "values" => [
                              "net" => rand(0, 1) == 1 ? 1 : -1,
                              "gross" => rand(0, 1) == 1 ? 1 : -1,
                         ],
                    ],
                    "oil" => [
                         "value" => [
                              "net" => rand(500000, 1_000_000),
                              "gross" => rand(500000, 1_000_000),
                         ],
                         "values" => [
                              "net" => rand(0, 1) == 1 ? 1 : -1,
                              "gross" => rand(0, 1) == 1 ? 1 : -1,
                         ],
                    ],
               ],
               [
                    "name" => "Belida",
                    "gas" => [
                         "value" => [
                              "net" => rand(500000, 1_000_000),
                              "gross" => rand(500000, 1_000_000),
                         ],
                         "values" => [
                              "net" => rand(0, 1) == 1 ? 1 : -1,
                              "gross" => rand(0, 1) == 1 ? 1 : -1,
                         ],
                    ],
                    "oil" => [
                         "value" => [
                              "net" => rand(500000, 1_000_000),
                              "gross" => rand(500000, 1_000_000),
                         ],
                         "values" => [
                              "net" => rand(0, 1) == 1 ? 1 : -1,
                              "gross" => rand(0, 1) == 1 ? 1 : -1,
                         ],
                    ],
               ]
          ];

          return $dataList;
     }
}
