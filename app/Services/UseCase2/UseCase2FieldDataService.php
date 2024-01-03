<?php
namespace App\Services\UseCase2;

use Illuminate\Support\Facades\Artisan;
use App\Models\UseCase2\UseCase2FieldData;

class UseCase2FieldDataService
{
     public function __construct(
          public $model = UseCase2FieldData::class
     ) {
     }


     public function findAllByDateAndType($date, $blockCode, $type, $try = false)
     {
          $dataItems = $this->model::query()
               ->where('date', $date)
               ->where('type', $type)
               ->where('block_code', $blockCode)
               ->get();

          if (!count($dataItems) && !$try) {
               Artisan::call('use-case-2:insert-field-dashboard-data');
               return $this->findAllByDateAndType($date, $blockCode, $type, true);
          }

          return $dataItems;
     }
}