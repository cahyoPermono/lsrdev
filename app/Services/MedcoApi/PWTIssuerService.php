<?php
namespace App\Services\MedcoApi;

use App\Enum\StatusCode;
use App\Helpers\MedcoApi;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class PWTIssuerService
{
     private $availableStatus = ['Printed', 'Issued', 'Activated', 'Close', 'On-Hold', 'Waiting Re-Issue'];
     public function __construct(
          protected string $url
     )
     {
          $this->url = Config::get('services.api.base_url');
          
     }
     public function findByPid($pid)
     {
          $apiUrl = $this->url . "MMAPSVC/PTW/GetPermitDetail?pid=$pid";
          $response = Http::get($apiUrl);
          $parseResponse = MedcoApi::successResponse($response);

          if ($parseResponse['status_code'] == StatusCode::SUCCESS){
               return [
                    'pid' => $pid,
                    'wp_number' => $parseResponse['data']['nomor_wp'],
                    'description' => $parseResponse['data']['deskripsi'],
                    'job_location' => $parseResponse['data']['lokasi_pekerjaan'],
                    'status' => $parseResponse['status']
               ];

          }     
          return MedcoApi::notFoundResponse();


          // ptw permit
          // return [
          //      'pid' => $pid,
          //      'wp_number' => '10-' . date('Y-M-d'),
          //      'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua',
          //      'job_location' => fake()->address(),
          //      'status' => $this->availableStatus[rand(0, count($this->availableStatus) - 1)]
          // ];
     }

     public function findAllWLByPidAndCode($pid, $code)
     {
          // get wl detail
          $apiUrl = $this->url . "MMAPSVC/PTW/GetWLDetail?ptsid_wl=$pid";
          $response = Http::get($apiUrl);
          $parseResponse = MedcoApi::successResponse($response);

          if ($parseResponse['status_code'] == StatusCode::SUCCESS){
               
               return [
                    'date' => date('Y-m-d', strtotime($parseResponse['header']['validity_wl'])),
                    'image' => $parseResponse['header']['foto_wl'],
                    'items' => $this->findAllWlItem($pid, $code)
               ];

          }

          return MedcoApi::notFoundResponse();
          // return [
          //      'date' => date('Y-m-d'),
          //      'image' => 'https://laz-img-cdn.alicdn.com/images/ims-web/TB1LLFTsljTBKNjSZFuXXb0HFXa.jpg_1200x1200.jpg',
          //      'items' => $this->findAllWlItem($pid, $code)
          // ];
     }

     private function findAllWlItem($pid, $code)
     {
          // detail 
          $apiUrl = $this->url . "MMAPSVC/PTW/GetWLDetail?ptsid_wl=$pid";
          $response = Http::get($apiUrl);
          $parseResponse = MedcoApi::successResponse($response);

          if ($parseResponse['status_code'] == StatusCode::SUCCESS){
               
               $items = [];
               for ($i = 0; $i < 5; $i++) {
                    $items[] = [
                         'permit_wan' => $parseResponse['detail']['pid_wan'],
                         'status' => $parseResponse['detail']['status']
                    ];
               }
               return $items;

          }

          return MedcoApi::notFoundResponse();
          // $items = [];
          // for ($i = 0; $i < 5; $i++) {
          //      $items[] = [
          //           'permit_wan' => rand(111, 9999),
          //           'status' => $this->availableStatus[rand(0, count($this->availableStatus) - 1)]
          //      ];
          // }
          // return $items;
     }
}