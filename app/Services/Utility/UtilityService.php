<?php
namespace App\Services\Utility;

use App\Models\Util\AppVersion;

class UtilityService{
     public function __construct(
          public $appVersion = AppVersion::class,
     ) {
     }

     public function findAppVersion($app){

          $res = $this->appVersion::where('app', $app)->latest()->first();
          return [
               'android_version' => $res ? $res->android_version : '0.0.0',
               'ios_version' => $res ? $res->ios_version: '0.0.0',
               'download_url' => $res ? $res->download_url : '',
               'text_template' => $res ? $res->text_template : '',
               'popup_title' => $res ? $res->popup_title : '',
               'button_text' =>  $res ? $res->button_text : '',
          ];
     }
}