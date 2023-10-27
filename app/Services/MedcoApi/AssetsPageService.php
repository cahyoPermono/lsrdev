<?php

namespace App\Services\MedcoApi;

use App\Services\MedcoApi\MainPageService; // Import MainPageService

class AssetsPageService
{
     private $mainPageService;

     public function __construct(MainPageService $mainPageService)
     {
          $this->mainPageService = $mainPageService;
     }

     public function userCaseMain($main_id)
     {
          return $this->mainPageService->userCaseMain($main_id);
     }

     public function assetsSummaryProduction()
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
                    ],
                    [
                         "title" => "YTD Production",
                         "value" => [
                              "net" => rand(500000, 1_000_000),
                              "gross" => rand(500000, 1_000_000),
                         ],
                    ],
               ],
          ];
     }

     public function assetsChartGas()
     {
          $data = [
               [
                    "month" => "October",
                    "title" => "Budget",
                    "value" => [
                         "net" => 12345,
                         "gross" => 67890,
                    ],
               ],
               [
                    "month" => "November",
                    "title" => "Actual",
                    "value" => [
                         "net" => 12345,
                         "gross" => 67890,
                    ],
               ],
               [
                    "month" => "December",
                    "title" => "Outlook",
                    "value" => [
                         "net" => 12345,
                         "gross" => 67890,
                    ],
               ]
          ];

          return $data;
     }

     public function assetsChartOil()
     {
          $data = [
               [
                    "month" => "October",
                    "title" => "Budget",
                    "value" => [
                         "net" => 12345,
                         "gross" => 67890,
                    ],
               ],
               [
                    "month" => "November",
                    "title" => "Actual",
                    "value" => [
                         "net" => 12345,
                         "gross" => 67890,
                    ],
               ],
               [
                    "month" => "December",
                    "title" => "Outlook",
                    "value" => [
                         "net" => 12345,
                         "gross" => 67890,
                    ],
               ]
          ];

          return $data;
     }

     public function assetsDataList()
     {
          $dataList = [
               [
                    "production" => "Block A",
                    "mmscfd" => [
                         "net" => rand(500000, 1_000_000),
                         "gross" => rand(500000, 1_000_000),
                    ],
                    "bpopd" => [
                         "net" => rand(500000, 1_000_000),
                         "gross" => rand(500000, 1_000_000),
                    ],
               ],
               [
                    "production" => "Dayung",
                    "mmscfd" => [
                         "net" => rand(500000, 1_000_000),
                         "gross" => rand(500000, 1_000_000),
                    ],
                    "bpopd" => [
                         "net" => rand(500000, 1_000_000),
                         "gross" => rand(500000, 1_000_000),
                    ],
               ],
               [
                    "production" => "Sumpal",
                    "mmscfd" => [
                         "net" => rand(500000, 1_000_000),
                         "gross" => rand(500000, 1_000_000),
                    ],
                    "bpopd" => [
                         "net" => rand(500000, 1_000_000),
                         "gross" => rand(500000, 1_000_000),
                    ],
               ],
               [
                    "production" => "Rawa Letang",
                    "mmscfd" => [
                         "net" => rand(500000, 1_000_000),
                         "gross" => rand(500000, 1_000_000),
                    ],
                    "bpopd" => [
                         "net" => rand(500000, 1_000_000),
                         "gross" => rand(500000, 1_000_000),
                    ],
               ],
               [
                    "production" => "Gelam",
                    "mmscfd" => [
                         "net" => rand(500000, 1_000_000),
                         "gross" => rand(500000, 1_000_000),
                    ],
                    "bpopd" => [
                         "net" => rand(500000, 1_000_000),
                         "gross" => rand(500000, 1_000_000),
                    ],
               ],
          ];

          return $dataList;
     }
}
