<?php
namespace App\Services\UseCase2;

use App\Models\UseCase2\UseCase2BlockChartData;
use Illuminate\Support\Facades\Artisan;
use App\Models\UseCase2\UseCase2BlockData;

class UseCase2BlockDataService
{
     public function __construct(
          public $model = UseCase2BlockData::class,
          public $chartModel = UseCase2BlockChartData::class
     ) {
     }


     public function findAllByDateAndType($date, $assetCode, $type, $try = false)
     {
          $dataItems = $this->model::query()
               ->where('date', $date)
               ->where('type', $type)
               ->where('asset_code', $assetCode)
               ->get();

          if (!count($dataItems) && !$try) {
               Artisan::call('use-case-2:insert-block-dashboard-data');
               return $this->findAllByDateAndType($date, $assetCode, $type, true);
          }

          return $dataItems;
     }

     
     public function findAllChartByDateRangeAndType($start, $end,$assetCode,$type, $try = false)
     {
          $dataItems = $this->chartModel::query()
               ->whereBetween('date', [$start, $end])
               ->where('type', $type)
               ->where('asset_code', $assetCode)
               ->get();

          if (!count($dataItems) && !$try) {
               Artisan::call('use-case-2:insert-block-chart-data');
               return $this->findAllChartByDateRangeAndType($start, $end,$assetCode,$type, true);
          }

          return $dataItems;
     }
}