<?php
namespace App\Services\MedcoApi;

use App\Helpers\Url;
use App\Enum\StatusCode;
use App\Helpers\MedcoApi;
use App\Helpers\MedcoRestful;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;

class TrainingService
{

     public function findAllTraining($ptsId)
     {
          /**
           * Fetch API Request
           */
          $restResponse = MedcoRestful::fetchData(
               url: Url::GetListTraining,
               query: [
                    "ptsid" => $ptsId
               ]
          );
          if (!$restResponse) {
               return [];
          }

          $trainings = collect(@$restResponse['training_list'] ?: []);
          return $trainings->map(fn($row) => [
               "training_name" => @$row['requirement_title'],
               "validity" => @$row['validity'],
               "valid_until" => date('Y-m-d', strtotime(@$row['expired_data'] ?: now()->subDays(1))),
               "contract_number" => @$row['contract_number'],
               "status" => @$row['active'],
               "contact_owner" => @$row['contract_owner'],
               "contract_period" => @$row['contract_period'],
               "npwp" => @$row['npwp'],
               "trainer" => @$row['name'],
               "nik" => @$row['nik'],
               "location" => @$row['location_title'],
               "position" => @$row['position_title'],
               "requirement_title" => @$row['requirement_title'],
               "requirement_type" => @$row['requirement_type'],
               "training_type" => @$row['training_type'],
               "last_taken" => @$row['last_taken'] ? date('Y-m-d', strtotime(@$row['last_taken'])) : null,
               "mandatory" => @$row['mandatory'],
               "personel_type" => null,
          ]);
     }
}