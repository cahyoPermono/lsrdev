<?php
namespace App\Services\Utility;

use App\Models\Util\AppVersion;

class UtilityService{
     public function __construct(
          public $appVersion = AppVersion::class,
     ) {
     }

     public function findAppVersion(){
          $app = $this->appVersion::query()->latest()->first();
          return [
               'android_version' => $app ? $app->android_version : '0.0.0',
               'ios_version' => $app ? $app->ios_version: '0.0.0',
               'download_url' => $app ? $app->download_url : '',
               'text_template' => $app ? $app->text_template : '',
               'popup_title' => $app ? $app->popup_title : '',
               'button_text' =>  $app ? $app->button_text : '',
          ];
     }
}