<?php
namespace App\Constanta;

class Setting {
     const MIN_ACTIVE_DAY = 'min_active_day';
     const HSE = HSE::class;
 }

class ITracUtility {
     const STATUS = 'status';
     const CREW_CHANGE_SCHEDULE = 'crew_change_schedule';
     const TRANSIT_POINT = 'transit_point';
     const DEPARTMENT = 'department';
     const FLIGHT_STATUS = 'flight_status';
     const HOME_BASE = 'home_base';
     const INTERSITE_SCHEDULE = 'intersite_schedule';
}

class HSE {
     const HIDE_LESSON = 'hse_hide_lesson';
     const HIDE_NEWS = 'hse_hide_news';
     const HIDE_POSTER = 'hse_hide_poster';
}

class Constanta
{
     const SETTING = Setting::class;
     const ITRAC_UTILITY = ITracUtility::class;
}