<?php
namespace App\Constanta;

class Setting {
     const ITRAC_STATUS = 'itrac_status';
     const ITRAC_SCHEDULE = 'itrac_schedule';
     const ITRAC_TRANSIT_POINT = 'itrac_transit_point';

     const MIN_ACTIVE_DAY = 'min_active_day';

     const HSE = HSE::class;
 }

class HSE {
     const HIDE_LESSON = 'hse_hide_lesson';
     const HIDE_NEWS = 'hse_hide_news';
     const HIDE_POSTER = 'hse_hide_poster';
}

class Constanta
{
     const SETTING = Setting::class;
}