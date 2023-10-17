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