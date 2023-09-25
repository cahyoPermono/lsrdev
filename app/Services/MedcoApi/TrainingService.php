<?php
namespace App\Services\MedcoApi;

class TrainingService
{
     public function findAllTraining($person_id)
     {
          return [
               [
                    "training_name" => "Medical Check Up",
                    "valid_until" => "2023-12-16",
                    "contract_number" => rand(111111, 999999),
                    "status" => "Active",
                    "contact_owner" => fake()->name(),
                    "contract_period" => rand(1, 99) . " Months",
                    "npwp" => "01.365.921.4-073." . rand(111, 999),
                    "trainer" => fake()->name(),
                    "nik" => "190933303993" . rand(111111, 999999),
                    "location" => fake()->address(),
                    "position" => "D/CADET (ABPL)",
                    "requirement_title" => "Medical Check Up",
                    "requirement_type" => "MCU",
                    "training_type" => "Technical Training",
                    "last_taken" => "00:00,0",
                    "mandatory" => "Yes",
                    "personel_type" => null,
               ],
               [
                    "training_name" => "BFA (Basic First Aid)",
                    "valid_until" => "2023-01-25",
                    "contract_number" => rand(111111, 999999),
                    "status" => "Active",
                    "contact_owner" => fake()->name(),
                    "contract_period" => rand(1, 99) . " Months",
                    "npwp" => "01.365.921.4-073." . rand(111, 999),
                    "trainer" => fake()->name(),
                    "nik" => "190933303993" . rand(111111, 999999),
                    "location" => fake()->address(),
                    "position" => "D/CADET (ABPL)",
                    "requirement_title" => "BFA (Basic First Aid)",
                    "requirement_type" => "BFA",
                    "training_type" => "Technical Training",
                    "last_taken" => "00:00,0",
                    "mandatory" => "Yes",
                    "personel_type" => null,
               ]
          ];
     }
}