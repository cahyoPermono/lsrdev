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

     public function findIsolationProcess($pid)
     {
          return [[
               "code" => null,
               "is_done" => null,
               "ip" => null,
               "required" => null,
               "lock" => null,
          ]];
     }

     public function findIsolationAutomation($pid)
     {
          return [];
     }

     public function findIsolationElectrical($pid)
     {
          return [];
     }

     public function findIsolationEsd($pid)
     {
          return [];
     }

     public function findIsolationPositive($pid)
     {
          return [];
     }
}