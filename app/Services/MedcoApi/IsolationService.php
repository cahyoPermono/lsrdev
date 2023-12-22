<?php
namespace App\Services\MedcoApi;

use App\Helpers\Url;
use App\Helpers\MedcoRestful;
use Illuminate\Auth\Events\Verified;
use Laililmahfud\Adminportal\Helpers\BadRequestException;

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
               "ic_no" => @$restResponse['ic_no'],
               "ic_status" => @$restResponse['ic_status'],
               "details" => collect(@$restResponse['detail'])->map(function($row){
                    return [
                         "name" => $row['isolation_method'],
                         "items" => collect($row['data'])->map(function($item){
                              return [
                                   "id" => @$item['ip_number'],
                                   "code" => @$item['funcloc'],
                                   "name" => @$item['ip_detail'],
                                   "is_done" => @$item['status']=='Done' ? true : false,
                                   "ip" => @$item['ip_number'],
                                   "required" => @$item['ip_type'],
                                   "lock" => @$item['lock_num'],
                                   "is_isolated" => @$item['isolator'] ? true : false,
                                   "verified_by" => @$item['verificator'],
                                   "status" => @$item['status'],
                                   "isolator" => @$item['isolator']
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


     public function postUpdateIsolation($pid,$ipNumber,$userPtsId,$userPtsName,$verificatorId,$verificatorName){
          try{
               $result = MedcoRestful::putAction(
                    url : Url::PutIcDetail,
                    query : [
                         "pid" => $pid,
                         "ipNumber" => $ipNumber,
                         "request" => "-"
                    ],
                    body : [
                         "isolator_onoff" => "Isolate",
                         "isolator_ptsid" => $userPtsId,
                         "isolator_name" => $userPtsName,
                         "verificator_onoff" => "Isolate",
                         "verificator_ptsid" => $verificatorId,
                         "verificator_name" => $verificatorName
                    ]
               );
               logger("PUT IC DETAIL RESULT");
               logger(json_encode($result));
          }catch(\Exception $e){
               throw new BadRequestException('Error hit api put ic detail');
          }
     }

}