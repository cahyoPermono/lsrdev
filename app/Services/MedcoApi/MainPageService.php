<?php

namespace App\Services\MedcoApi;

class MainPageService
{
    public function userCaseMain()
    {
        return [
            [
                "value" => [
                    "net" => rand(500000, 1_000_000),
                    "gross" => rand(500000, 1_000_000),
                ],
                "title" => "MEDC.",
                "date" => "2023-08-24",
            ],
            [
                "value" => [
                    "net" => rand(500000, 1_000_000),
                    "gross" => rand(500000, 1_000_000),
                ],
                "title" => "Brent",
                "date" => "2023-08-24",
            ],
            [
                "value" => [
                    "net" => rand(500000, 1_000_000),
                    "gross" => rand(500000, 1_000_000),
                ],
                "title" => "CPI",
                "date" => "2023-08-24",
            ],
        ];
    }

    public function mainSummaryProduction()
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

    public function mainChartGas()
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

    public function mainChartOil()
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


    public function mainDataList()
    {
        $dataList = [
            [
                "production" => "Corridor",
                "mmscfd" => rand(500000, 1_000_000),
                "bpopd" => rand(500000, 1_000_000),
            ],
            [
                "production" => "Onshore",
                "mmscfd" => rand(500000, 1_000_000),
                "bpopd" => rand(500000, 1_000_000),
            ],
            [
                "production" => "Offshore",
                "mmscfd" => rand(500000, 1_000_000),
                "bpopd" => rand(500000, 1_000_000),
            ],
            [
                "production" => "Noa",
                "mmscfd" => rand(500000, 1_000_000),
                "bpopd" => rand(500000, 1_000_000),
            ],
            [
                "production" => "International",
                "mmscfd" => rand(500000, 1_000_000),
                "bpopd" => rand(500000, 1_000_000),
            ],
        ];

        return $dataList;
    }
}
