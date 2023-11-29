<?php
namespace App\Services\MedcoApi;

use App\Helpers\Url;
use App\Helpers\MedcoRestful;
use Illuminate\Auth\Events\Verified;

class IsolationService
{
     public function findByPid($pid)
     {
          /**
           * Fetch API Request
           */
          $restResponse = MedcoRestful::fetchData(
               url: Url::GetListIsolation,
               query: [
                    "pid" => $pid
               ]
          );
          if(!$restResponse){
               return null;
          }
          return [
               "pid" => @$restResponse['pid'],
               "ic_detail" => @$restResponse['ic_detail'],
               "location" => @$restResponse['location'],
               "details" => collect(@$restResponse['detail'])->map(function($row){
                    return [
                         "name" => $row['isolation_method'],
                         "items" => collect($row['data'])->map(function($item){
                              return [
                                   "id" => @$item['ip_number'],
                                   "code" => "ID-N-CG-MU-23-23DE" . rand(111, 999),
                                   "name" => @$item['ip_detail'],
                                   "is_done" => false,
                                   "ip" => @$item['ip_number'],
                                   "required" => @$item['ip_type'],
                                   "lock" => "2",
                                   "is_isolated" => false,
                                   "verified_by" => null
                              ];
                         })
                    ];
               })
          ];
     }

     public function findVerificator($ptsid){
          $restResponse = MedcoRestful::fetchData(
               url: Url::GetVerificatorDetail,
               query: [
                    "ptsid" => $ptsid
               ]
          );
          if(!$restResponse){
               return null;
          }
          return [
               'pts_id' => @$restResponse['pts_id'],
               'name' => @$restResponse['name_wl'],
               'validity' => @$restResponse['validity_wl'],
               'role_verificator' => @$restResponse['role_verificator'],
          ];
     }

}