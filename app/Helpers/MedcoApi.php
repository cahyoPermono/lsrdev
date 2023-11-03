<?php 
namespace App\Helpers;
use App\Enum\StatusCode;

class MedcoApi {
  public static function successResponse($response) {
    $data = $response->json();

    return [
       "status_code"=> StatusCode::SUCCESS,
       "message" => "Success",
       "data" => $data['data'] ?? []
    ];
  }
  public static function notFoundResponse() {
    return [];
  }
}