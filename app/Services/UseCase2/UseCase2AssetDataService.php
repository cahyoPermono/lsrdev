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
               // ->whereBetween('date', [$start, $end])
               ->where('type', $type)
               ->where('company_code', $companyCode);

          if (!$query->clone()->count() && !$try) {
               Artisan::call('use-case-2:insert-asset-chart-data');
               return $this->findAllChartByDateRangeAndType($start, $end, $companyCode, $type, true);
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
               ])
               ->orderBy('date','asc')
               ->get();

          return $dataItems;
     }
}