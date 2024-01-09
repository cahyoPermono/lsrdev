<?php
namespace App\Services\UseCase2;

use App\Models\UseCase2\UseCase2CompanyChartData;
use App\Models\UseCase2\UseCase2CompanyData;
use Illuminate\Support\Facades\Artisan;

class UseCase2CompanyDataService
{
     public function __construct(
          public $model = UseCase2CompanyData::class,
          public $chartModel = UseCase2CompanyChartData::class
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

     public function findAllChartByDateRangeAndType($start, $end, $type, $try = false)
     {
          $dataItems = $this->chartModel::query()
               ->whereBetween('date', [$start, $end])
               ->where('type', $type)
               ->get();

          if (!count($dataItems) && !$try) {
               Artisan::call('use-case-2:insert-company-chart-data');
               return $this->findAllChartByDateRangeAndType($start, $end, $type, true);
          }

          return $dataItems;
     }
}