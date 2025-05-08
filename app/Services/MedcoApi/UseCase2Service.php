<?php
namespace App\Services\MedcoApi;

use App\Helpers\Url;
use App\Helpers\MedcoRestful;
use App\Models\UseCase2\UseCase2Price;

class UseCase2Service
{
     public function summaryStockPrice()
     {
          $medcoPrice = UseCase2Price::where('code', 'stock')->first();
          $brentPrice = UseCase2Price::where('code', 'brent')->first();
          $wtiPrice = UseCase2Price::where('code', 'wti')->first();

          return [
               $medcoPrice,
               $brentPrice,
               $wtiPrice
          ];
     }
}