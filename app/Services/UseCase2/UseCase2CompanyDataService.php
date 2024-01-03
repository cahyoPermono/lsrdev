<?php
namespace App\Services\UseCase2;

use App\Models\UseCase2\UseCase2CompanyData;
use Illuminate\Support\Facades\Artisan;

class UseCase2CompanyDataService
{
     public function __construct(
          public $model = UseCase2CompanyData::class
     ) {
     }


     public function findAllByDateAndType($date, $type, $try = false)
     {
          $dataItems = $this->model::query()
               ->where('date', $date)
               ->where('type', $type)
               ->get();

          if (!count($dataItems) && !$try) {
               Artisan::call('use-case-2:insert-company-dashboard-data');
               return $this->findAllByDateAndType($date, $type, true);
          }

          return $dataItems;
     }
}