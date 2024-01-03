<?php
namespace App\Services\UseCase2;

use Illuminate\Support\Facades\Artisan;
use App\Models\UseCase2\UseCase2AssetData;

class UseCase2AssetDataService
{
     public function __construct(
          public $model = UseCase2AssetData::class
     ) {
     }


     public function findAllByDateAndType($date, $companyCode, $type, $try = false)
     {
          $dataItems = $this->model::query()
               ->where('date', $date)
               ->where('type', $type)
               ->where('company_code', $companyCode)
               ->get();

          if (!count($dataItems) && !$try) {
               Artisan::call('use-case-2:insert-asset-dashboard-data');
               return $this->findAllByDateAndType($date, $companyCode, $type, true);
          }

          return $dataItems;
     }
}