<?php
namespace App\Services\Hse;

use App\Models\Hse\HseDocument;
use App\Models\Hse\HseEvent;
use App\Models\Hse\HseLeasonLearned;
use App\Models\Hse\HseNews;
use App\Models\Hse\HsePopupCampaign;
use App\Models\Hse\HseQuizz;
use App\Models\Hse\HseSafetyPoster;
use App\Models\Util\BannerCampaign;

class HseUtilityService
{
     public function __construct(
          private $slider = BannerCampaign::class,
          private $popupCampaign = HsePopupCampaign::class,
          private $event = HseEvent::class,
          private $document = HseDocument::class,
          private $quizz = HseQuizz::class,
          private $leassonLearned = HseLeasonLearned::class,
          private $safetyPoster = HseSafetyPoster::class,
          private $news = HseNews::class,
     ) {
     }

     public function findAllSlider()
     {
          return $this->slider::query()
               ->select(['id', 'title', 'url', 'file as image'])
               ->latest('start_at')
               ->get();
     }

     public function findFirstPopupCampaign()
     {
          return $this->popupCampaign::query()
               ->select(['id', 'title', 'url', 'file as image'])
               ->latest('start_at')
               ->first();
     }

     public function findAllTopUpcomingEvent($limit, $date)
     {
          return $this->event::query()
               ->whereDate('start_at', '>=', $date)
               ->select(['id', 'title', 'start_at', 'end_at'])
               ->oldest('start_at')
               ->limit($limit)
               ->get();
     }

     public function findAllEvent($startAt, $endDate)
     {
          return $this->event::query()
               ->whereBetween('start_at', [$startAt . " 00:00:00", $endDate . " 23:59:59"])
               ->select(['id', 'title', 'start_at', 'end_at'])
               ->oldest('start_at')
               ->get();
     }

     public function findAllDocument($limit = 20)
     {
          return $this->document::query()
               ->select(['name', 'description', 'start_at'])
               ->latest('start_at')
               ->paginate($limit)
               ->transform(function ($row) {
                    $row->is_new = now()->diffInDays($row->start_at) <= 30 ? true : false;
                    return $row;
               });
     }

     public function findFirstQuizz()
     {
          return $this->quizz::query()
               ->select(['id', 'title', 'url', 'file'])
               ->latest('id')
               ->first();
     }

     public function findAllLeassonLearned($limit = 10)
     {
          return $this->leassonLearned::query()
               ->latest('id')
               ->paginate($limit)
               ->items();
     }

     public function findAllSafetyPoster($limit = 10)
     {
          return $this->safetyPoster::query()
               ->latest('id')
               ->paginate($limit)
               ->items();
     }

     public function findAllNews($limit = 10)
     {
          return $this->news::query()
               ->latest('id')
               ->paginate($limit)
               ->items();
     }
}