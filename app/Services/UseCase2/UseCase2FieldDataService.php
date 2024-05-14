<?php
namespace App\Services\UseCase2;

use Illuminate\Support\Facades\Artisan;
use App\Models\UseCase2\UseCase2FieldData;
use App\Models\UseCase2\UseCase2FieldSummary;

class UseCase2FieldDataService
{
     public function __construct(
          public $model = UseCase2FieldData::class,
          public $summaryModel = UseCase2FieldSummary::class
     ) {
     }


     public function findAllByDateAndType($date, $blockCode, $type, $try = false)
     {
          $dataItems = $this->model::query()
               ->where('date', $date)
               ->where('type', $type)
               ->where('block_code', $blockCode)
               ->orderBy('date','asc')
               ->get();

          if (!count($dataItems) && !$try) {
               Artisan::call('use-case-2:insert-field-dashboard-data');
               return $this->findAllByDateAndType($date, $blockCode, $type, true);
          }

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
}