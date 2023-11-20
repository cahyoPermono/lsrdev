<?php
namespace App\Services\MedcoApi;

use App\Enum\StatusCode;
use App\Helpers\MedcoApi;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class CertificateUserService
{
     public function __construct(
          protected string $url
     )
     {
          $this->url = Config::get('services.api.base_url');
          
     }
     private static function fakeCertificate()
     {
          /**
           *  {
           *     "email": "abdul.hakim@contractor.medcoenergi.com",
           *     "person_id": 19823818,
           *     "first_name": "Abdul",
           *     "middle_name": "",
           *     "last_name": "HAKIM",
           *     "sex": "M",
           *     "nationality": "Indonesia",
           *     "department_name": "Information Technology",
           *     "company_name": "JASNIKOM GEMANUSA PT",
           *     "person_status": "A",
           *     "supervisor": 13979786,
           *     "b2b_person_id": 19821141
           *  }
           */
          return collect(Storage::json('json/certificate-users.json'));
     }

     public function certificate($personId)
     {
          // $certificates = self::fakeCertificate()->where('person_id', $personId)->values();
          $apiUrl = $this->url . "MMAPSVC/PTS/GetListCertificate?personid=$personId";
          $response = Http::get($apiUrl);
          $parseResponse = MedcoApi::successResponse($response);
          if ($parseResponse['status_code'] == StatusCode::SUCCESS) {
               $certificates = $parseResponse['data']['certificate'];
               $medical = $this->findCertificateByCode($certificates, 'MCU')->first();
               $orientation = $this->findCertificateByCode($certificates, 'HSEORI')->first();
               $covid = $this->findCertificateByCode($certificates, 'COVID')->sortBy('certificate_code')->values();
     
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
                              'name' => $row['certificate_name'],
                              'valid_until' => date('Y-m-d', strtotime($row['expire_date'])),
                              'code' => $row['certificate_code'],
                         ])
                    ];
               }
     
               return $result;
               
          } else {
               return MedcoApi::notFoundResponse();
          }
     }

     public function ptsCertificate($personId)
     {
          $apiUrl = $this->url . "MMAPSVC/PTS/GetListCertificate?personid=$personId";
          $response = Http::get($apiUrl);

          $parseResponse = MedcoApi::successResponse($response);

          if ($parseResponse['status_code'] == StatusCode::SUCCESS) {
               // $certificates = self::fakeCertificate()->where('person_id', $personId)->values();
               $certificates = $parseResponse['data']['certificate'];
               $certificates = $certificates->filter(function ($row) {
                    $code = @$row['certificate_code'];
                    return !str_contains($code, 'MCU') && !str_contains($code, 'HSEORI') && !str_contains($code, 'COVID');
               })->values();
               return $certificates->map(fn($row) => [
                    'name' => $row['certificate_name'],
                    'valid_until' => date('Y-m-d', strtotime($row['expire_date'])),
                    'issue_date' => date('Y-m-d', strtotime($row['issue_date'])),
                    'registered_date' => date('Y-m-d', strtotime($row['registered_date'])),
                    'changed_date' => date('Y-m-d', strtotime($row['changed_date'])),
                    'code' => $row['certificate_code'],
                    'type' => $row['certificate_type'],
                    'clinic_doctor' => $row['clinic'],
               ]);
               
          } else {
               return MedcoApi::notFoundResponse();
          }
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
               'name' => $certificate['certificate_name'],
               'valid_until' => date('Y-m-d', strtotime($certificate['expire_date'])),
               'code' => $certificate['certificate_code'],
               'items' => []
          ];
     }
}