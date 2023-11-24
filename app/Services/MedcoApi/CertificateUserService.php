<?php
namespace App\Services\MedcoApi;

use App\Enum\StatusCode;
use App\Helpers\MedcoApi;
use App\Helpers\MedcoRestful;
use App\Helpers\Url;
use Illuminate\Support\Facades\Http;

class CertificateUserService
{
     public function certificate($personId)
     {
          /**
           * Fetch API Request
           */
          $restResponse = MedcoRestful::fetchData(
               url: Url::ListCertificate,
               query: [
                    "personid" => $personId
               ]
          );
          if (!$restResponse) {
               return [];
          }
          /**
           * Collect Certificate Data
           */
          $certificates = collect(@$restResponse['certificates'] ?: []);

          /**
           * Filter Certificate By Code
           */
          $medical = $this->findCertificateByCode($certificates, 'MCU')->first();
          $orientation = $this->findCertificateByCode($certificates, 'HSEORI')->first();
          $covid = $this->findCertificateByCode($certificates, 'COVID')->sortBy('certificate_code')->values();

          /**
           * Add Certificate
           */
          $result = [];
          if ($medical) {
               $result[] = $this->certificateObject($medical);
          }
          if ($orientation) {
               $result[] = $this->certificateObject($orientation);
          }
          if (count($covid)) {
               $result[] = [
                    "name" => "Covid Vaccine",
                    "valid_until" => null,
                    "code" => "COVID",
                    "items" => $covid->map(fn($row) => [
                         'name' => !$row['certificate_name'],
                         'valid_until' => date('Y-m-d', strtotime(@$row['expire_date'] ?: now())),
                         'code' => @$row['certificate_code'],
                    ])
               ];
          }

          return $result;
     }

     public function ptsCertificate($personId)
     {
          /**
           * Fetch API Request
           */
          $restResponse = MedcoRestful::fetchData(
               url: Url::ListCertificate,
               query: [
                    "personid" => $personId
               ]
          );
          if (!$restResponse) {
               return [];
          }

          
          /**
           * Collect Certificate Data
           */
          $certificates = collect(@$restResponse['certificates'] ?: []);

          $certificates = $certificates->filter(function ($row) {
               $code = @$row['certificate_code'];
               return !str_contains($code, 'MCU') && !str_contains($code, 'HSEORI') && !str_contains($code, 'COVID');
          })->values();
          
          return $certificates->map(fn($row) => [
               'name' => @$row['certificate_name'],
               'valid_until' => date('Y-m-d', strtotime(@$row['expire_date'])),
               'issue_date' => date('Y-m-d', strtotime(@$row['issue_date'])),
               'registered_date' => date('Y-m-d', strtotime(@$row['registered_date'])),
               'changed_date' => date('Y-m-d', strtotime(@$row['changed_date'])),
               'code' => @$row['certificate_code'],
               'type' => @$row['certificate_type'],
               'clinic_doctor' => @$row['clinic'],
          ]);
     }


     private function findCertificateByCode($certificates, $codeCertificate)
     {
          return $certificates->filter(function ($row) use ($codeCertificate) {
               $code = @$row['certificate_code'];
               return str_contains($code, $codeCertificate);
          })->values();
     }

     private function certificateObject($certificate)
     {
          return [
               'name' => @$certificate['certificate_name'],
               'valid_until' => date('Y-m-d', strtotime(@$certificate['expire_date'] ?: now())),
               'code' => @$certificate['certificate_code'],
               'items' => []
          ];
     }
}