<?php
use Illuminate\Support\Carbon;

if (!function_exists('diffDays')) {
     function diffDays($start, $end = null): mixed
     {
          $lastLoginDate = Carbon::parse($start);
          $currentDate = $end ?: now();
          return $currentDate->diffInDays($lastLoginDate);
     }
}

if (!function_exists('dateTimeFromString')) {
     function dateTimeFromString($string,$format = null): mixed
     {
          if($string){
               return Carbon::parse($string)->format($format ?: 'Y-m-d H:i:s');
          }
          return null;
     }
}

if (!function_exists('compareVersions')) {
     function compareVersions($version1, $version2) {
          $v1Parts = explode('.', $version1);
          $v2Parts = explode('.', $version2);
          
          for ($i = 0; $i < max(count($v1Parts), count($v2Parts)); $i++) {
              $v1 = isset($v1Parts[$i]) ? (int)$v1Parts[$i] : 0;
              $v2 = isset($v2Parts[$i]) ? (int)$v2Parts[$i] : 0;
              
              if ($v1 < $v2) {
                  return -1;
              } elseif ($v1 > $v2) {
                  return 1;
              }
          }
          
          return 0;
     }
}