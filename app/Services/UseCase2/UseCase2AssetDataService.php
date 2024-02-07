<?php
namespace App\Services\UseCase2;

use App\Models\UseCase2\UseCase2AssetChartData;
use Illuminate\Support\Facades\Artisan;
use App\Models\UseCase2\UseCase2AssetData;
use App\Models\UseCase2\UseCase2AssetSummary;
use Illuminate\Support\Facades\DB;

class UseCase2AssetDataService
{
     public function __construct(
          public $model = UseCase2AssetData::class,
          public $chartModel = UseCase2AssetChartData::class,
          public $summaryModel = UseCase2AssetSummary::class
     ) {
     }


     public function findAllByDateAndType($date, $companyCode, $type, $try = false)
     {
          $dataItems = $this->model::query()
               ->where('date', $date)
               ->where('type', $type)
               ->where('company_code', $companyCode)
               ->orderBy('date','asc')
               ->get();

          if (!count($dataItems) && !$try) {
               Artisan::call('use-case-2:insert-asset-dashboard-data');
               return $this->findAllByDateAndType($date, $companyCode, $type, true);
          }

          return $dataItems;
     }

     public function findSummary($companyCode, $try = false)
     {
          $data = $this->summaryModel::query()
               ->where('company_code', $companyCode)
               ->first();

          if (!$data && !$try) {
               Artisan::call('use-case-2:insert-asset-summary-data');
               return $this->findSummary($companyCode,true);
          }

          return $data;
     }

     public function findAllChartByDateRangeAndType($start, $end, $companyCode, $type, $try = false)
     {
          $query = $this->chartModel::query()
               ->whereBetween('date', [$start, $end])
               ->where('type', $type)
               ->where('company_code', $companyCode);

          if (!$query->clone()->count() && !$try) {
               Artisan::call('use-case-2:insert-asset-chart-data');
               return $this->findAllChartByDateRangeAndType($start, $end, $companyCode, $type, true);
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
               ->groupBy('date_label')
               ->orderBy('date_label','asc')
               ->get();

          return $dataItems;
     }
}