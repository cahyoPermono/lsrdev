<?php
namespace App\Services\MedcoApi;

class CompetencyService
{
     public function findAllCompetency($person_id)
     {
          $resultStatus = ["Fail", "Pass"];
          return [
               [
                    "competency_name" => "Electrical Safety Level " . rand(1, 9),
                    "valid_until" => "2023-12-24",
                    "assessment_result" => $resultStatus[rand(0, 1)],
                    "assessor" => fake()->name(),
                    "company" => fake()->company(),
                    "location" => fake()->address(),
                    "assessment_date" => "2023-01-23",
                    "assessment_method" => "Test",
               ],
               [
                    "competency_name" => "Ground Disturbance Certificate Fill in Knowledge",
                    "valid_until" => "2023-01-24",
                    "assessment_result" => $resultStatus[rand(0, 1)],
                    "assessor" => fake()->name(),
                    "company" => fake()->company(),
                    "location" => fake()->address(),
                    "assessment_date" => "2023-01-23",
                    "assessment_method" => "Test",
               ]
          ];
     }
}