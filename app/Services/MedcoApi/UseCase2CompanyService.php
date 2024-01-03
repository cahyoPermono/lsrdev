<?php
namespace App\Services\MedcoApi;

use App\Services\UseCase2\UseCase2CompanyDataService;
use Carbon\CarbonPeriod;
use Illuminate\Support\Str;


class UseCase2CompanyService
{
    public function __construct(
        private $useCase2CompanyDataService = new UseCase2CompanyDataService
    ){}

    
    public function summary()
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

    public function gasChart($filter)
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

    public function oilChart($filter)
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

    public function productionData($limit = 10)
    {
        $date = now()->subDays(1)->format('Y-m-d');
        return $this->useCase2CompanyDataService->findAllByDateAndType($date,'production')->map(fn($row)=>[
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

    public function salesData($limit = 10)
    {
        $date = now()->subDays(1)->format('Y-m-d');
        return $this->useCase2CompanyDataService->findAllByDateAndType($date,'sales')->map(fn($row)=>[
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
