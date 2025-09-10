<?php
namespace App\Services\UseCase2;

use App\Models\UseCase2\UseCase2CompanyQuarterlyData;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use App\Models\UseCase2\UseCase2CompanyData;
use App\Models\UseCase2\UseCase2CompanyChartData;
use App\Models\UseCase2\UseCase2CompanySummary;
use App\Models\UseCase2\UseCase2CompanyYtdProductionBreakdown;
use Barryvdh\Debugbar\Facades\Debugbar;

class UseCase2CompanyDataService
{
     public function __construct(
          public $model = UseCase2CompanyData::class,
          public $chartModel = UseCase2CompanyChartData::class,
          public $summaryModel = UseCase2CompanySummary::class,
          public $productionBreakdownModel = UseCase2CompanyYtdProductionBreakdown::class,
          public $quarterlyDataModel = UseCase2CompanyQuarterlyData::class
     ) {
     }


     public function findAllByDateAndType($date, $type, $try = false)
     {
          $dataItems = $this->model::query()
               ->where('date', $date)
               ->where('type', $type)
               ->orderBy('date','asc')
               ->get();

          if (!count($dataItems) && !$try) {
               Artisan::call('use-case-2:insert-company-dashboard-data');
               return $this->findAllByDateAndType($date, $type, true);
          }

          return $dataItems;
     }

     public function findSummary($try = false)
     {
          $data = $this->summaryModel::query()->first();

          if (!$data && !$try) {
               Artisan::call('use-case-2:insert-company-summary-data');
               return $this->findSummary(true);
          }

          return $data;
     }

     public function findAllChartByDateRangeAndType($start, $end, $type, $try = false)
     {
          $query = $this->chartModel::query()
               // ->whereBetween('date', [$start, $end])
               ->where('type', $type);

          if (!$query->clone()->count() && !$try) {
               Artisan::call('use-case-2:insert-company-chart-data');
               return $this->findAllChartByDateRangeAndType($start, $end, $type, true);
          }
          $dataItems = $query->clone()
               ->select([
                    'date as date_label',
                    "actual_net",
                    "actual_gross",
                    "budget_net",
                    "budget_gross",
                    "outlook_net",
                    "outlook_gross",
                    "wpnb_net",
                    "wpnb_gross",
                    "apbn_net",
                    "apbn_gross",
               ])
               ->orderBy('date','asc')
               ->get();


          return $dataItems;
     }

     public function findProductionBreakdown($type) {
          return UseCase2CompanyYtdProductionBreakdown::where('type', $type)
               ->select('country_code', 'working_interest', 'ytd_production', 'budget', 'delta', 'percent')
               ->get();
     }

     public function findAllQuarterlyDataByType($type)
     {
          $dataItems = $this->quarterlyDataModel::query()
               ->where('type', $type)
               ->orderBy('quarter','asc')
               ->get();
          Debugbar::info($dataItems);
          return $dataItems;
     }
}