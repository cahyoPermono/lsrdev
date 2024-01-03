<?php
namespace App\Services\UseCase2;

use Illuminate\Support\Facades\Artisan;
use App\Models\UseCase2\UseCase2BlockData;

class UseCase2BlockDataService
{
     public function __construct(
          public $model = UseCase2BlockData::class
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
}