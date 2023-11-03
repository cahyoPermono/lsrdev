<?php
namespace App\Services\MedcoApi;

use App\Enum\StatusCode;
use App\Helpers\MedcoApi;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class TrainingService
{
     public function __construct(
          protected string $url
     )
     {
          $this->url = Config::get('services.api.base_url');
          
     }
     public function findAllTraining($ptsId)
     {
          $apiUrl = $this->url . "MMAPSVC/CTMS/GetListTraining?ptsid=$ptsId";
          $response = Http::get($apiUrl);
          $parseResponse = MedcoApi::successResponse($response);

          if ($parseResponse['status_code'] == StatusCode::SUCCESS){
               $training = $parseResponse['data']['training_list'];

               return $training->map(fn($row) => [
                    "training_name" => $row['requirement_title'],
                    "valid_until" => $row['expired_data'],
                    "contract_number" => $row['contract_number'],
                    "status" => $row['active'],
                    "contact_owner" => $row['contract_owner'],
                    "contract_period" => $row['contract_period'],
                    "npwp" => $row['npwp'],
                    "trainer" => $row['name'],
                    "nik" => $row['nik'],
                    "location" => $row['location_title'],
                    "position" => $row['position_title'],
                    "requirement_title" => $row['requirement_title'],
                    "requirement_type" => $row['requirement_type'],
                    "training_type" => $row['training_type'],
                    "last_taken" => date('Y-m-d', strtotime($row['last_taken'])),
                    "mandatory" => $row['mandatory'],
                    "personel_type" => null,
               ]);
          } else {
               return MedcoApi::notFoundResponse();
          }

          // return [
          //      [
          //           "training_name" => "Medical Check Up",
          //           "valid_until" => "2023-12-16",
          //           "contract_number" => rand(111111, 999999),
          //           "status" => "Active",
          //           "contact_owner" => fake()->name(),
          //           "contract_period" => rand(1, 99) . " Months",
          //           "npwp" => "01.365.921.4-073." . rand(111, 999),
          //           "trainer" => fake()->name(),
          //           "nik" => "190933303993" . rand(111111, 999999),
          //           "location" => fake()->address(),
          //           "position" => "D/CADET (ABPL)",
          //           "requirement_title" => "Medical Check Up",
          //           "requirement_type" => "MCU",
          //           "training_type" => "Technical Training",
          //           "last_taken" => "00:00,0",
          //           "mandatory" => "Yes",
          //           "personel_type" => null,
          //      ],
          //      [
          //           "training_name" => "BFA (Basic First Aid)",
          //           "valid_until" => "2023-01-25",
          //           "contract_number" => rand(111111, 999999),
          //           "status" => "Active",
          //           "contact_owner" => fake()->name(),
          //           "contract_period" => rand(1, 99) . " Months",
          //           "npwp" => "01.365.921.4-073." . rand(111, 999),
          //           "trainer" => fake()->name(),
          //           "nik" => "190933303993" . rand(111111, 999999),
          //           "location" => fake()->address(),
          //           "position" => "D/CADET (ABPL)",
          //           "requirement_title" => "BFA (Basic First Aid)",
          //           "requirement_type" => "BFA",
          //           "training_type" => "Technical Training",
          //           "last_taken" => "00:00,0",
          //           "mandatory" => "Yes",
          //           "personel_type" => null,
          //      ]
          // ];
     }
}