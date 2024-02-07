<?php
namespace App\Services\UseCase2;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use App\Models\UseCase2\UseCase2CompanyData;
use App\Models\UseCase2\UseCase2CompanyChartData;
use App\Models\UseCase2\UseCase2CompanySummary;

class UseCase2CompanyDataService
{
     public function __construct(
          public $model = UseCase2CompanyData::class,
          public $chartModel = UseCase2CompanyChartData::class,
          public $summaryModel = UseCase2CompanySummary::class,
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
               ->whereBetween('date', [$start, $end])
               ->where('type', $type);

          if (!$query->clone()->count() && !$try) {
               Artisan::call('use-case-2:insert-company-chart-data');
               return $this->findAllChartByDateRangeAndType($start, $end, $type, true);
          }
          $dataItems = $query->clone()
               ->select([
                    'date_label',
                    DB::raw("sum(actual_net) as actual_net"),
                    DB::raw("sum(actual_gross) as actual_gross"),
                    DB::raw("sum(budget_net) as budget_net"),
                    DB::raw("sum(budget_gross) as budget_gross"),
                    DB::raw("sum(outlook_net) as outlook_net"),
                    DB::raw("sum(outlook_gross) as outlook_gross"),
               ])
               ->orderBy('date_label','asc')
               ->groupBy('date_label')
               ->get();

          return $dataItems;
     }
}