<?php
namespace App\Actions\PWTIssuer;

use App\Helpers\Url;
use Illuminate\Http\Request;
use App\Helpers\MedcoRestful;
use Illuminate\Http\Response;
use Laililmahfud\Adminportal\Helpers\BadRequestException;

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

               $statusCode = @$result['status_code'] ?: @$result['status'];
               if (!in_array($statusCode, [Response::HTTP_OK, Response::HTTP_CREATED])) {
                    throw new BadRequestException(@$result['message']);
               }
          } catch (\Exception $e) {
               logger("ERROR UPDATE WL PERMIT DETAIL");
               logger($e);
               throw new BadRequestException('Error hit api put permit detail');
          }
     }
}