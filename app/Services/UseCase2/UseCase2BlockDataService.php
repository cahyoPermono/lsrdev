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
     ) {}


     public function findAllByDateAndType($date, $assetCode, $type, $try = false)
     {
          $dataItems = $this->model::query()
               ->where('date', $date)
               ->where('type', $type)
               ->where('asset_code', $assetCode)
               ->orderBy('date', 'asc')
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
               return $this->findSummary($assetCode, true);
          }

          return $data;
     }


     public function findAllChartByDateRangeAndType($start, $end, $blockName, $type)
     {
          $dataItems = $this->chartModel::query()
               ->whereBetween('date', [$start, $end])
               ->where('type', $type)
               ->where('block_name', $blockName)
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
               ->orderBy('date', 'asc')
               ->get();

          return $dataItems;
     }
}
