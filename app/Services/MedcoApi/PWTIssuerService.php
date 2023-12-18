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
          if(!$restResponse){
               return null;
          }

          return [
               'pid' => strval(@$restResponse['pid']),
               'wp_number' => @$restResponse['nomor_wp'],
               'description' => @$restResponse['deskripsi'],
               'job_location' => @$restResponse['lokasi_pekerjaan'],
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
                    "ptsid_wl" => $pid
               ]
          );
          if(!$restResponse){
               return null;
          }
          $header = @$restResponse['header'] ?: [];
          $detail = @$restResponse['detail'] ?: [];
          return [
               'date' => date('Y-m-d', strtotime(@$header['validity_wl']?:now())),
               'image' => @$header['foto_wl'],
               'items' => [
                    [
                         'permit_wan' => @$detail['pid_wan'],
                         'status' => @$detail['status'],
                         'pid' => @$detail['pid'],
                         'permit_no' => @$detail['permit_no'],
                         'wan_no' => @$detail['wan_no'],
                    ]
               ]
               // 'items' => $this->findAllWlItem($pid, $code)
          ];
     }
}