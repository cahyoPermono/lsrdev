<?php

namespace App\Services\MedcoApi;


class AssetsPageService extends MainPageService
{
     public function userCaseAssets($main_id)
     {
          return parent::userCaseMain();
     }

     public function assetsSummaryProduction($main_id)
     {
          return parent::mainSummaryProduction();
     }

     public function assetsChartGas($main_id, $filter = null)
     {
          return parent::mainChartGas($filter);
     }

     public function assetsChartOil($main_id, $filter = null)
     {
          return parent::mainChartOil($filter);
     }

     public function assetsDataList($main_id)
     {
          return parent::mainDataList();
     }
}
