<?php
namespace App\Services\MedcoApi;

use App\Helpers\Url;
use App\Helpers\MedcoRestful;

class TrainingService
{

     public function findAllTraining($ptsId, $email)
     {
          $emails = explode('@', $email);
          $emailDomain = "@".@$emails[1];
          $allowedEmailDomainMedco = ['@medcoenergi.com', '@tc.medcoenergi.com'];

          if (in_array($emailDomain, $allowedEmailDomainMedco)) {
               return $this->findAllTrainingMedcoUser($email);
          }
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
               "valid_until" => @$row['expired_date'] ? date('Y-m-d', strtotime(@$row['expired_date'])) : null,
               "contract_number" => @$row['contract_number'],
               "status" => @$row['status'],
               "contact_owner" => @$row['contract_owner'],
               "contract_period" => @$row['contract_period'] ?: "N/A",
               "npwp" => @$restResponse['npwp'],
               "trainer" => @$restResponse['name'],
               "nik" => @$restResponse['nik'],
               "location" => @$row['location_title'],
               "position" => @$row['position_title'],
               "requirement_title" => @$row['requirement_title'],
               "requirement_type" => @$row['requirement_type'],
               "training_type" => @$row['training_type'],
               "last_taken" => @$row['last_taken'] ? date('Y-m-d', strtotime(@$row['last_taken'])) : null,
               "mandatory" => @$row['mandatory'],
               "personel_type" => null,
               "detail_category" => null,
               "detail" => null
          ]);
     }

     private function findAllTrainingMedcoUser($email){
          $restResponse = MedcoRestful::fetchData(
               url: Url::GetListTrainingByEmail,
               query: [
                    "email" => $email
               ]
          );
          if (!$restResponse) {
               return [];
          }

          $trainings = collect(@$restResponse ?: []);

          return $trainings->map(fn($row) => [
               "training_name" => @$row['course_name'],
               'validity' => @$row['valid_status'] ? 'Valid' : 'Invalid', 
               "valid_until" => @$row['valid_until'] ? date('Y-m-d', strtotime(@$row['valid_until'])) : null,
               "contract_number" => @$row['course_id'],
               "status" => @$row['valid_status'] ? 'Active' : 'Inactive',
               "contact_owner" => '',
               "contract_period" => "N/A",
               "npwp" => '-',
               "trainer" => '-',
               "nik" => '',
               "location" => '',
               "position" => @$row['job_role_name'],
               "requirement_title" => @$row['course_name'],
               "requirement_type" => @$row['course_type'],
               "training_type" => @$row['course_type'],
               "last_taken" => @$row['last_training_date'] ? date('Y-m-d', strtotime(@$row['last_training_date'])) : null,
               "mandatory" => 'Yes',
               "personel_type" => null,
               "detail_category" => 'one',
               "detail" => [
                    'payroll_id' => @$row['payroll_id'],
                    'name' => @$row['employee_name'],
                    'job_role_id' => @$row['job_role_id'],
                    'job_role_name' => @$row['job_role_name'],
                    'job_role_effective_date' => @$row['jobrole_effective_date'] ? date('Y-m-d',strtotime($row['jobrole_effective_date'])) : null,
                    'employee_status' => @$row['employment_status'],
                    'employee_effective_date' =>  @$row['employee_effective_date'] ? date('Y-m-d',strtotime($row['employee_effective_date'])) : null,
                    'course_id' => @$row['course_id'], 
                    'course_name' => @$row['course_name'], 
                    'course_type' => @$row['course_type'], 
                    'last_training_date' => @$row['last_training_date'] ? date('Y-m-d',strtotime($row['last_training_date'])) : null,
                    'valid_until' =>  @$row['valid_until'] ? date('Y-m-d',strtotime($row['valid_until'])) : null,
                    'validity' => @$row['valid_status'] ? 'Valid' : 'Invalid', 
                    'record_id' => @$row['record_id'], 
               ]
          ]);
     }
}