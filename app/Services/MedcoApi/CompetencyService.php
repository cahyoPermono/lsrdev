<?php
namespace App\Services\MedcoApi;

use App\Helpers\MedcoRestful;
use App\Helpers\Url;

class CompetencyService
{
     public function findAllCompetency($ptsId)
     {

          /**
           * Fetch API Request
           */
          $restResponse = MedcoRestful::fetchData(
               url: Url::ListCompetency,
               query: [
                    "ptsid" => $ptsId
               ]
          );
          if (!$restResponse) {
               return [];
          }

          /**
           * Collect Certificate Data
           */
          $competencies = collect(@$restResponse['competencies'] ?: []);
          return $competencies->map(
               fn($row) =>
               [
                    "competency_name" => @$row['competency_name'],
                    "valid_until" => date('Y-m-d', strtotime(@$row['valid_date'] ?: now())),
                    "assessment_result" => @$row['assessement_result'],
                    "assessor" => @$restResponse['name'],
                    "company" => @$restResponse['company'],
                    "location" => @$restResponse['location_title'],
                    "assessment_date" => date('Y-m-d', strtotime(@$row['assessment_date'] ?: now())),
                    "assessment_method" => @$row['assessement_method'],
               ]
          );
     }
}