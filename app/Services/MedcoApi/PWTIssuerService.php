<?php
namespace App\Services\MedcoApi;

use App\Helpers\Url;
use App\Enum\StatusCode;
use App\Helpers\MedcoApi;
use App\Helpers\MedcoRestful;
use Illuminate\Support\Facades\Http;

class PWTIssuerService
{
     public function findByPid($pid)
     {
          /**
           * Fetch API Request
           */
          $restResponse = MedcoRestful::fetchData(
               url: Url::GetPermitDetail,
               query: [
                    "pid" => $pid
               ]
          );
          if (!$restResponse) {
               return null;
          }

          return [
               'pid' => strval(@$restResponse['pid']),
               'wp_number' => @$restResponse['number_wp'],
               'description' => @$restResponse['description'],
               'job_location' => @$restResponse['work_location'],
               'status' => @$restResponse['status'],
               'ic_number' => @$restResponse['ic_number'],
               'ic_status' => @$restResponse['ic_status'],
          ];
     }

     public function findAllWLByPidAndCode($pid, $code)
     {
          /**
           * Fetch API Request
           */
          $restResponse = MedcoRestful::fetchData(
               url: Url::GetWLDetail,
               query: [
                    "ptsid" => $code
               ]
          );
          if (!$restResponse) {
               return null;
          }
          $data = $restResponse;
          $detail = @$data['wan_details'] ?: [];
          return [
               'date' => date('Y-m-d', strtotime(@$data['validity_wl'] ?: now())),
               'image' => @$data['photo_wl'],
               'items' => collect($detail)->map(fn($row) => [
                    'permit_wan' => "", //@$detail['pid_wan'],
                    'status' => @$row['status'],
                    'pid' => strval(@$row['pid']),
                    'permit_no' => @$row['permit_no'],
                    'wan_no' => "" //@$detail['wan_no'],
               ])
               // 'items' => $this->findAllWlItem($pid, $code)
          ];
     }
}