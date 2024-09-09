<?php
namespace App\Services\MedcoApi;

use App\Helpers\Url;
use App\Helpers\MedcoRestful;

class UseCase2Service
{
     public function summaryStockPrice()
     {
          $medcoPrice = MedcoRestful::fetchData(
               url: Url::GetMedcoStockPrice
          );
          $brentPrice = MedcoRestful::fetchData(
               url: Url::GetCrudeBrentStockPrice
          );
          $cpiPrice = MedcoRestful::fetchData(
               url: Url::GetCPIStockPrice
          );

          return [
               $this->putObject($medcoPrice, "MEDC"),
               $this->putObject($brentPrice, "Brent"),
               $this->putCPI($cpiPrice, "CPI")
          ];
     }

     private function putObject($json, $title)
     {
          $date = $json ? $json['Date'] : now();
          return [
               "title" => $title,
               "date" => $date,
               "value" => @$json['Value'] ?: 0,
               "delta" => @$json['Delta'] ?: 0,
               "percent" => @$json['PCT'] ?: 0,
          ];
     }

     private function putCPI($json, $title)
     {
          $date = $json ? $json['Date'] : now();
          return [
               "title" => $title,
               "date" => $date,
               "value" => @$json['Value'] ?: 0,
               "delta" => @$json['Change'] ?: 0,
               "percent" => @$json['PCT'] ?: 0,
          ];
     }
}