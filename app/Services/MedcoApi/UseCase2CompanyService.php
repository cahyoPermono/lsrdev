<?php
namespace App\Services\MedcoApi;

use App\Helpers\MedcoRestful;
use App\Helpers\Url;
use App\Services\UseCase2\UseCase2CompanyDataService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Str;


class UseCase2CompanyService
{
    public function __construct(
        private $useCase2CompanyDataService = new UseCase2CompanyDataService
    ) {
    }


    public function summary()
    {
        $data = $this->useCase2CompanyDataService->findSummary();
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

    public function gasChart($filter)
    {
        $period = @$filter['period'] ?: 'YTD';
        $endDate = date('Y-m-d');
        $startDate = $period === '360_DAYS' ? now()->subDays(360)->startOfDay()->format('Y-m-d') : date('Y-01-01');

        return $this->useCase2CompanyDataService->findAllChartByDateRangeAndType($startDate, $endDate, 'gas')->map(function ($row) {
            $date = Carbon::parse($row->date_label);
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

    public function oilChart($filter)
    {
        $period = @$filter['period'] ?: 'YTD';
        $endDate = date('Y-m-d');
        $startDate = $period === '360_DAYS' ? now()->subDays(360)->startOfDay()->format('Y-m-d') : date('Y-01-01');

        return $this->useCase2CompanyDataService->findAllChartByDateRangeAndType($startDate, $endDate, 'oil')->map(function ($row) {
            $date = Carbon::parse($row->date_label);
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

    public function productionData($limit = 10)
    {
        $date = now()->subDays(1)->format('Y-m-d');
        return $this->useCase2CompanyDataService->findAllByDateAndType($date, 'production')->map(fn($row) => [
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
        return $this->useCase2CompanyDataService->findAllByDateAndType($date, 'sales')->map(fn($row) => [
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
