<?php
namespace App\Services\MedcoApi;

use Illuminate\Support\Facades\Storage;

class SelfScreeningService
{
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
          $certificates = self::fakeCertificate()->where('person_id', $personId)->values();
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
                         'valid_until' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['expire_date'])->format('Y-m-d'),
                         'code' => $row['certificate_code'],
                    ])
               ];
          }

          return $result;
     }

     public function ptsCertificate($personId)
     {
          $certificates = self::fakeCertificate()->where('person_id', $personId)->values();
          $certificates = $certificates->filter(function ($row) {
               $code = @$row['certificate_code'];
               return !str_contains($code, 'MCU') && !str_contains($code, 'HSEORI') && !str_contains($code, 'COVID');
          })->values();
          return $certificates->map(fn($row) => [
               'name' => $row['certificate_name'],
               'valid_until' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['expire_date'])->format('Y-m-d'),
               'issue_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['issue_date'])->format('Y-m-d'),
               'registered_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['registered_date'])->format('Y-m-d'),
               'changed_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['changed_date'])->format('Y-m-d'),
               'code' => $row['certificate_code'],
               'type' => $row['certificate_type'],
               'clinic_doctor' => $row['clinic'],
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
               'name' => $certificate['certificate_name'],
               'valid_until' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($certificate['expire_date'])->format('Y-m-d'),
               'code' => $certificate['certificate_code'],
               'items' => []
          ];
     }
}