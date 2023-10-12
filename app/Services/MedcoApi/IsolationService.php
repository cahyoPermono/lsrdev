<?php
namespace App\Services\MedcoApi;

use Illuminate\Auth\Events\Verified;

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
          return [
               [
                    "id" => "ID-N-CG-MU-23-23DE" . rand(111, 999),
                    "code" => "ID-N-CG-MU-23-23DE" . rand(111, 999),
                    "name" => fake()->name(),
                    "is_done" => true,
                    "ip" => "I0000" . rand(1, 9),
                    "required" => "CLO",
                    "lock" => rand(1, 9),
                    "is_isolated" => true,
                    "verified_by" => fake()->name(),
               ],
               [
                    "id" => "ID-N-CG-MU-23-23DE" . rand(111, 999),
                    "code" => "ID-N-CG-MU-23-23DE" . rand(111, 999),
                    "name" => fake()->name(),
                    "is_done" => false,
                    "ip" => "I0000" . rand(1, 9),
                    "required" => "CLO",
                    "lock" => rand(1, 9),
                    "is_isolated" => false,
                    "verified_by" => null
               ]
          ];
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