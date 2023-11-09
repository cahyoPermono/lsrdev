<?php
namespace App\Services\MedcoApi;

class UseCase2Service
{
     public function summaryStockPrice()
     {
          return [
               [
                    "title" => "MEDCO",
                    "date" => date('Y-m-d'),
                    "value" => rand(10_000, 1_000_000),
                    "delta" => rand(-5, 2),
                    "percent" => rand(-5, 0.5),
               ],
               [
                    "title" => "Brent",
                    "date" => date('Y-m-d'),
                    "value" => rand(10_000, 1_000_000),
                    "delta" => rand(-5, 2),
                    "percent" => rand(-5, 0.5),
               ],
               [
                    "title" => "CPI",
                    "date" => date('Y-m-d'),
                    "value" => rand(10_000, 1_000_000),
                    "delta" => rand(-5, 2),
                    "percent" => rand(-5, 0.5),
               ]
          ];
     }
}