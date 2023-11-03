<?php
namespace App\Services\MedcoApi;

use App\Enum\StatusCode;
use App\Helpers\MedcoApi;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class CompetencyService
{
     public function __construct(
          protected string $url
     )
     {
          $this->url = Config::get('services.api.base_url');
          
     }
     public function findAllCompetency($ptsId)
     {
          
          $apiUrl = $this->url . "MMAPSVC/CTMS/GetListCompetency?ptsid=$ptsId";
          $response = Http::get($apiUrl);
          $parseResponse = MedcoApi::successResponse($response);
          
          if($parseResponse['status_code'] == StatusCode::SUCCESS) {
               $competency = collect($parseResponse['data']['competencies']);
               return $competency->map(fn ($row) => 
                    [
                         "competency_name" => $row['competency_name'],
                         "valid_until" =>  date('Y-m-d', strtotime($row['valid_date'])),
                         "assesment_result" => $row['assesment_result'],
                         "assessor" => $parseResponse['data']['name'],
                         "company" => $parseResponse['data']['company'],
                         "location" => $parseResponse['data']['location_title'],
                         "assesment_date" => date('Y-m-d', strtotime($row['assesment_date'])),
                         "assesment_method" => $row['assesment_method'],
                    ]
               );
          ;
          } 
          return MedcoApi::notFoundResponse();
          
          // $resultStatus = ["Fail", "Pass"];
          // return [
               //      [
          //           "competency_name" => "Electrical Safety Level " . rand(1, 9),
          //           "valid_until" => "2023-12-24",
          //           "assessment_result" => $resultStatus[rand(0, 1)],
          //           "assessor" => $competency[''],
          //           "company" => fake()->company(),
          //           "location" => fake()->address(),
          //           "assessment_date" => "2023-01-23",
          //           "assessment_method" => "Test",
          //      ],
          // ];
          
          // return [
          //      [
          //           "competency_name" => "Electrical Safety Level " . rand(1, 9),
          //           "valid_until" => "2023-12-24",
          //           "assessment_result" => $resultStatus[rand(0, 1)],
          //           "assessor" => fake()->name(),
          //           "company" => fake()->company(),
          //           "location" => fake()->address(),
          //           "assessment_date" => "2023-01-23",
          //           "assessment_method" => "Test",
          //      ],
          //      [
          //           "competency_name" => "Ground Disturbance Certificate Fill in Knowledge",
          //           "valid_until" => "2023-01-24",
          //           "assessment_result" => $resultStatus[rand(0, 1)],
          //           "assessor" => fake()->name(),
          //           "company" => fake()->company(),
          //           "location" => fake()->address(),
          //           "assessment_date" => "2023-01-23",
          //           "assessment_method" => "Test",
          //      ]
          // ];
     }
}