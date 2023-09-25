<?php
namespace App\Services\MedcoApi;

class IsolationService
{
     public function findByPid($pid)
     {
          return [
               "pid" => $pid,
               "ic_detail" => "Test IC For issue",
               "location" => fake()->address()
          ];
     }
}