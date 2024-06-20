<?php

namespace App\Console\Commands\Hse;

use App\Helpers\MedcoRestful;
use App\Helpers\Url;
use App\Models\Hse\HsePopupCampaign;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertHsePopupCampaignData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hse:insert-hse-popup-campaign';

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
            url : Url::GetHsePopupCampaign
        );
        if ($itemData) {
            DB::transaction(function () use ($itemData) {
                HsePopupCampaign::query()->delete();
                $items = collect($itemData)->chunk(200);
                foreach ($items as $data) {
                    $itemData = $data->map(function ($row){
                        return [
                            'title' => @$row['Title'],
                            'description' => @$row['Description'],
                            'author' => @$row['Author'] ?: '',
                            'start_at' => dateTimeFromString(@$row['Start_x0020_Date']) ?: '',
                            'end_at' => dateTimeFromString(@$row['End_x0020_Date']) ?: '',
                            'file' => @$row['FileBase64'] ?: '',
                            'url' => @$row['_dlc_DocIdUrl'] ?: '',
                            'keyword' => @$row['Keywords'] ?: '',
                        ];
                    })->toArray();
                    HsePopupCampaign::insert($itemData);
                }
            });
        }
    }
}
