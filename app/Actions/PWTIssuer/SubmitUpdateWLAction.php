<?php
namespace App\Actions\PWTIssuer;

use App\Helpers\Url;
use Illuminate\Http\Request;
use App\Helpers\MedcoRestful;

class SubmitUpdateWLAction
{
     public function handle(Request $request, $personId, $pid, $code)
     {
          try {
               $result = MedcoRestful::putAction(
                    url: Url::PutPermitDetail,
                    query: [
                         "pid" => $pid,
                         "status" => $request->status,
                         "personid" => $personId,
                         "ptsid" => $code
                    ]
               );
               logger("PUT PERMIT DETAIL RESULT");
               logger(json_encode($result));
          } catch (\Exception $e) {
               logger("ERROR UPDATE WL PERMIT DETAIL");
               logger($e);
          }
     }
}