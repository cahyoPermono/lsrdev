<?php

namespace App\Services\MedcoApi;

use App\Services\UseCase2\UseCase2CompanyDataService;
use App\Services\UseCase2\UseCase2AssetDataService;
use Barryvdh\Debugbar\Facades\Debugbar;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Str;


class UseCase2CompanyService
{
    public function __construct(
        private UseCase2CompanyDataService $useCase2CompanyDataService,
        private UseCase2AssetDataService $useCase2AssetDataService
    ) {}


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

    public function chart($filter, $type)
    {
        $period = @$filter['period'];
        $dateRange = getDateRange($period);
        $startDate = $dateRange['start'];
        $endDate   = $dateRange['end'];
        $assetKinds = ['Corridor', 'Onshore', 'Offshore', 'NOA', 'International', 'Domestic'];

        $assetActualData =  $this->useCase2AssetDataService->findAllChartsForActualData($startDate, $endDate, 'Domestic', $type);
        $domesticBudgetData = $this->useCase2AssetDataService->getBudgetChart($startDate, $endDate, 'Domestic', $type);

        $groupedAssetData = [];
        foreach ($assetActualData as $row) {
            $date = $row->date;
            $assetKind = $row->asset_kind;
            $groupedAssetData[$date][$assetKind] = [
                'net' => (float) $row->actual_net,
                'gross' => (float) $row->actual_gross,
            ];
        }

        foreach ($domesticBudgetData as $row) {
            $date = $row->date;
            $assetKind = 'MEPIBudget';
            $groupedAssetData[$date][$assetKind] = [
                'net' => (float) $row->budget_net,
                'gross' => (float) $row->budget_gross,
            ];
        }

        return $this->useCase2CompanyDataService
            ->findAllChartByDateRangeAndType($startDate, $endDate, $type)
            ->map(
                function ($row) use ($groupedAssetData) {
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
                    $wpnb = [
                        'net' => (float) $row->wpnb_net,
                        'gross' => (float) $row->wpnb_gross,
                    ];
                    $apbn = [
                        'net' => (float) $row->apbn_net,
                        'gross' => (float) $row->apbn_gross,
                    ];
                    $items = [
                        [
                            'label' => "Budget",
                            'slug' => 'budget',
                            'value' => $budget,
                            'percent' => $budget
                        ],
                        [
                            'label' => "Actual",
                            'slug' => 'actual',
                            'value' => $actual,
                            'percent' => $budget
                        ],
                        [
                            'label' => "Outlook",
                            'slug' => 'outlook',
                            'value' => $outlook,
                            'percent' => $budget
                        ],
                        [
                            'label' => "WPNB",
                            'slug' => 'wpnb',
                            'value' => $wpnb,
                            'percent' => $budget
                        ],
                        [
                            'label' => "APBN",
                            'slug' => 'apbn',
                            'value' => $apbn,
                            'percent' => $budget
                        ]
                    ];

                    if (isset($groupedAssetData[$row->date_label])) {
                        foreach ($groupedAssetData[$row->date_label] as $assetKind => $assetData) {
                            $items[] = [
                                'label' => ucfirst($assetKind),
                                'slug' => strtolower($assetKind),
                                'value' => [
                                    'net' => (float) $assetData['net'],
                                    'gross' => (float) $assetData['gross'],
                                ]
                            ];
                        }
                    }

                    return [
                        'date' => $date->format('Y-m-d'),
                        'date_label' => $date->format('d M Y'),
                        'month' => $date->format('M'),
                        'year' => $date->format('Y'),
                        'day' => $date->format('d'),
                        'items' => $items
                    ];
                }
            );
    }

    public function productionData()
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

    public function salesData()
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

    public function productionVsBudgetData()
    {
        $data = $this->useCase2AssetDataService->findActualVsBudgetDelta()->map(function ($item) {
            return [
                'name' => $item->asset_kind,
                'type' => $item->type,
                'value' => [
                    'net' => [
                        'actual' => [
                            'value' => (float) $item->actual_net_avg,
                            'delta' => (float) 0,
                        ],
                        'budget' => [
                            'value' => (float) $item->budget_net_avg,
                            'delta' => (float) $item->delta_budget_net,
                        ],
                        'wpnb' => [
                            'value' => (float) $item->wpnb_net_avg,
                            'delta' => (float) $item->delta_wpnb_net,
                        ],
                        'apbn' => [
                            'value' => (float) $item->apbn_net_avg,
                            'delta' => (float) $item->delta_apbn_net,
                        ],

                    ],
                    'gross' => [
                        'actual' => [
                            'value' => (float) $item->actual_gross_avg,
                            'delta' => (float) 0,
                        ],
                        'budget' => [
                            'value' => (float) $item->budget_gross_avg,
                            'delta' => (float) $item->delta_budget_gross,
                        ],
                        'wpnb' => [
                            'value' => (float) $item->wpnb_gross_avg,
                            'delta' => (float) $item->delta_wpnb_gross,
                        ],
                        'apbn' => [
                            'value' => (float) $item->apbn_gross_avg,
                            'delta' => (float) $item->delta_apbn_gross,
                        ],
                    ],
                ],
            ];
        })->values();
        return $data;
    }

    public function productionBreakdown()
    {
        $data = $this->useCase2CompanyDataService->findProductionBreakdown('total');
        Debugbar::info($data);
        return $data->groupBy('country_code')->map(function ($rows, $countryCode) {
            $result = ['country_code' => $countryCode];

            foreach (['gross', 'nett'] as $interest) {
                $row = $rows->firstWhere('working_interest', $interest);

                $result[$interest] = [
                    'ytd_production' => $row->ytd_production ?? 0,
                    'budget'         => $row->budget ?? 0,
                    'delta'          => $row->delta ?? 0,
                    'percent'        => $row->percent ?? 0,
                ];
            }

            return $result;
        })->values();
    }
    public function quarterlyProductionData()
    {
        $raw = $this->useCase2CompanyDataService->findAllQuarterlyDataByType('production');

        $grouped = [];

        $currentYear = date('Y');
        $currentQuarter = ceil(date('n') / 3);

        $emptyMetrics = [
            "current" => null,
            "previous" => null,
            "delta" => null,
            "percent" => null,
        ];

        foreach ($raw as $row) {
            $code = $row->asset_kind;

            $isFuture = (
                $row->year > $currentYear ||
                ($row->year == $currentYear && $row->quarter > $currentQuarter)
            );

            $grouped[$code]['code'] = $code;
            $grouped[$code]['name'] = $code;
            $grouped[$code]['items'][] = [
                'quarter' => $row->quarter,
                'year' => $row->year,
                'gas' => [
                    "net"   => $isFuture ? $emptyMetrics : $row->gas_net,
                    "gross" => $isFuture ? $emptyMetrics : $row->gas_gross,
                ],
                'oil' => [
                    "net"   => $isFuture ? $emptyMetrics : $row->oil_net,
                    "gross" => $isFuture ? $emptyMetrics : $row->oil_gross,
                ],
            ];
        }


        return collect($grouped);
    }
}
