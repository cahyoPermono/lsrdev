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

          return [
               [
                    "id" => "GG-MU-21-21DE" . rand(111, 999),
                    "code" => "GG-MU-21-21DE" . rand(111, 999),
                    "name" => fake()->name(),
                    "is_done" => true,
                    "ip" => "I0000" . rand(1, 9),
                    "required" => "CLO",
                    "lock" => rand(1, 9),
                    "is_isolated" => true,
                    "verified_by" => fake()->name(),
               ],
               [
                    "id" => "ID-N-CG-MU-21-21DE" . rand(111, 999),
                    "code" => "ID-N-CG-MU-21-21DE" . rand(111, 999),
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

     public function findIsolationElectrical($pid)
     {
          return [
               [
                    "id" => "OKE-OC-20-20DE" . rand(111, 999),
                    "code" => "OKE-OC-20-20DE" . rand(111, 999),
                    "name" => fake()->name(),
                    "is_done" => true,
                    "ip" => "I0000" . rand(1, 9),
                    "required" => "CLO",
                    "lock" => rand(1, 9),
                    "is_isolated" => true,
                    "verified_by" => fake()->name(),
               ],
               [
                    "id" => "OKE-OC-20-20DE" . rand(111, 999),
                    "code" => "OKE-OC-20-20DE" . rand(111, 999),
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

     public function findIsolationEsd($pid)
     {
          return [
               [
                    "id" => "CROCO-11-11DE" . rand(111, 999),
                    "code" => "CROCO-11-11DE" . rand(111, 999),
                    "name" => fake()->name(),
                    "is_done" => true,
                    "ip" => "I0000" . rand(1, 9),
                    "required" => "CLO",
                    "lock" => rand(1, 9),
                    "is_isolated" => true,
                    "verified_by" => fake()->name(),
               ],
               [
                    "id" => "CROCO-11-11DE" . rand(111, 999),
                    "code" => "CROCO-11-11DE" . rand(111, 999),
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

     public function findIsolationPositive($pid)
     {
          return [
               [
                    "id" => "IDN-MDK-DE" . rand(111, 999),
                    "code" => "IDN-MDK-DE" . rand(111, 999),
                    "name" => fake()->name(),
                    "is_done" => true,
                    "ip" => "I0000" . rand(1, 9),
                    "required" => "CLO",
                    "lock" => rand(1, 9),
                    "is_isolated" => true,
                    "verified_by" => fake()->name(),
               ],
               [
                    "id" => "IDN-MDK-DE" . rand(111, 999),
                    "code" => "IDN-MDK-DE" . rand(111, 999),
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
}