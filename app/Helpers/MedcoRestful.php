<?php
namespace App\Helpers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class MedcoRestful
{

     public static function fetchData($url, $query = null)
     {
          if ($query) {
               $query = "?" . http_build_query($query);
          }
          $url = config('services.api.medco_rest_url') . $url . $query;
          $result = Http::withoutVerifying()
               ->get($url)
               ->json();

          $statusCode = @$result['status_code'] ?: @$result['status'];
          if ($statusCode === Response::HTTP_OK) {
               return @$result['data'] ?: $result;
          }
          return null;
     }


     public static function putAction($url, $query = null)
     {
          if ($query) {
               $query = "?" . http_build_query($query);
          }
          $url = config('services.api.medco_rest_url') . $url . $query;
          $result = Http::withoutVerifying()
               ->get($url)
               ->json();

          $statusCode = @$result['status_code'] ?: @$result['status'];
          if (@$statusCode === Response::HTTP_OK) {
               return @$result['data'] ?: $result;
          }
          return null;
     }

}