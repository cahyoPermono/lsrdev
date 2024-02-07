<?php
namespace App\Services\UseCase2;

use App\Models\UseCase2\UseCase2BlockChartData;
use Illuminate\Support\Facades\Artisan;
use App\Models\UseCase2\UseCase2BlockData;
use App\Models\UseCase2\UseCase2BlockSummary;
use Illuminate\Support\Facades\DB;

class UseCase2BlockDataService
{
     public function __construct(
          public $model = UseCase2BlockData::class,
          public $chartModel = UseCase2BlockChartData::class,
          public $summaryModel = UseCase2BlockSummary::class
     ) {
     }


     public function findAllByDateAndType($date, $assetCode, $type, $try = false)
     {
          $dataItems = $this->model::query()
               ->where('date', $date)
               ->where('type', $type)
               ->where('asset_code', $assetCode)
               ->orderBy('date','asc')
               ->get();

          if (!count($dataItems) && !$try) {
               Artisan::call('use-case-2:insert-block-dashboard-data');
               return $this->findAllByDateAndType($date, $assetCode, $type, true);
          }

          return $dataItems;
     }

     public function findSummary($assetCode, $try = false)
     {
          $data = $this->summaryModel::query()
               ->where('asset_code', $assetCode)
               ->first();

          if (!$data && !$try) {
               Artisan::call('use-case-2:insert-block-summary-data');
               return $this->findSummary($assetCode,true);
          }

          return $data;
     }

     
     public function findAllChartByDateRangeAndType($start, $end,$assetCode,$type, $try = false)
     {
          $query = $this->chartModel::query()
               ->whereBetween('date', [$start, $end])
               ->where('type', $type)
               ->where('asset_code', $assetCode);

          if (!$query->clone()->count() && !$try) {
               Artisan::call('use-case-2:insert-block-chart-data');
               return $this->findAllChartByDateRangeAndType($start, $end,$assetCode,$type, true);
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