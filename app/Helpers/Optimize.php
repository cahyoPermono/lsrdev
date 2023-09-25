<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class Optimize
{
     public static function cache($key, $callback, $ttl = 300)
     {
          $optimizeKey = Cache::get('optimize-keys') ?: [];
          $optimizeKey[] = $key;
          Cache::put("optimize-keys", array_unique($optimizeKey));

          return Cache::remember($key, $ttl, $callback);
     }

     public static function cacheForever($key, $callback): mixed
     {
          return Cache::rememberForever($key, $callback);
     }

     public static function clearUserCache($userId)
     {
          foreach (Cache::get('optimize-keys') ?: [] as $key) {
               if (str_contains($key, ":{$userId}-id")) {
                    Cache::forget($key);
               }
          }
          Cache::forget('optimize-keys');
     }
}
