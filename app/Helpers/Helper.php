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
     function dateTimeFromString($string): mixed
     {
          if($string){
               return Carbon::parse($string)->format('Y-m-d H:i:s');
          }
          return null;
     }
}