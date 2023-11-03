<?php

namespace App\Services\MedcoApi;

use App\Services\MedcoApi\MainPageService;


class AssetsPageService
{
     private $mainPageService;

     public function __construct(MainPageService $mainPageService)
     {
          $this->mainPageService = $mainPageService;
     }

     public function userCaseAssets($main_id)
     {
          $entries = $this->mainPageService->userCaseMain();
          return $entries;
     }


     public function assetsSummaryProduction($main_id)
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

     public function assetsChartGas($main_id, $filter = null)
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


     public function assetsChartOil($main_id, $filter = null)
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




     public function assetsDataList($main_id)
     {
          $dataList = [
               [
                    "name" => "Block A",
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
                    "name" => "Dayung",
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
                    "name" => "Sumpal",
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
                    "name" => "Rawa Letang",
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
                    "name" => "Gelam",
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
