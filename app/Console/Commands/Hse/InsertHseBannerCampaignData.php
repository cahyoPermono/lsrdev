<?php

namespace App\Console\Commands\Hse;

use App\Helpers\MedcoRestful;
use App\Helpers\Url;
use App\Models\Util\BannerCampaign;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertHseBannerCampaignData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hse:insert-hse-banner-campaign';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $itemData = MedcoRestful::fetchData(
            url : Url::GetHseBannerCampaign
        );
        BannerCampaign::query()->delete();
        if ($itemData) {
            DB::transaction(function () use ($itemData) {
                $items = collect($itemData)->chunk(200);
                foreach ($items as $data) {
                    $itemData = $data->map(function ($row){
                        return [
                            'title' => @$row['Title'] ?: '',
                            'description' => @$row['Description'] ?: '',
                            'file' => @$row['FileBase64'] ?: '',
                            'keyword' => @$row['Keywords'] ?: '',
                            'url' => @$row['_dlc_DocIdUrl'] ?: '',
                            'author' => @$row['Author'] ?: '',
                            'start_at' => dateTimeFromString(@$row['Start_x0020_Date']) ?: '',
                            'end_at' => dateTimeFromString(@$row['End_x0020_Date']) ?: '',
                        ];
                    })->toArray();
                    BannerCampaign::insert($itemData);
                }
            });
        }
    }
}
