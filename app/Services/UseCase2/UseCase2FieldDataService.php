<?php
namespace App\Services\UseCase2;

use Illuminate\Support\Facades\Artisan;
use App\Models\UseCase2\UseCase2FieldData;
use App\Models\UseCase2\UseCase2FieldSummary;
use App\Models\UseCase2\UseCase2FieldChartData;

class UseCase2FieldDataService
{
     public function __construct(
          public $model = UseCase2FieldData::class,
          public $summaryModel = UseCase2FieldSummary::class,
          public $chartModel = UseCase2FieldChartData::class,
     ) {
     }


     public function findAllByDateAndType($date, $blockCode, $type, $try = false)
     {
          $exclude_blocks = config('usecase2.blocks_without_well_data');
          $dataItems = $this->model::query()
               ->where('date', $date)
               ->where('type', $type)
               ->where('block_code', $blockCode)
               ->whereNotIn('asset_code', $exclude_blocks)
               ->orderBy('date','asc')
               ->get();

          return $dataItems;
     }

     public function findSummary($blockCode, $try = false)
     {
          $data = $this->summaryModel::query()
               ->where('block_code', $blockCode)
               ->first();

          if (!$data && !$try) {
               Artisan::call('use-case-2:insert-field-summary-data');
               return $this->findSummary($blockCode,true);
          }

          return $data;
     }

     public function findAllChartByDateRangeAndType($start, $end, $blockCode, $type, $try = false)
     {
          $query = $this->chartModel::query()
               ->where('type', $type)
               ->where('block_code', $blockCode);

          if (!$query->clone()->count() && !$try) {
               Artisan::call('use-case-2:insert-field-chart-data');
               return $this->findAllChartByDateRangeAndType($start, $end,$blockCode,$type, true);
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