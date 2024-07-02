<?php

namespace App\Console\Commands\Hse;

use App\Helpers\MedcoRestful;
use App\Helpers\Url;
use App\Models\Hse\HseSafetyPoster;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertHsePosterData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hse:insert-hse-poster';

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
            url : Url::GetHsePoster
        );
        if ($itemData) {
            DB::transaction(function () use ($itemData) {
                HseSafetyPoster::query()->delete();
                $items = collect($itemData)->chunk(200);
                foreach ($items as $data) {
                    $itemData = $data->map(function ($row){
                        return [
                            'title' => @$row['Title'],
                            'author' => @$row['Author'] ?: '',
                            'file' => @$row['FileBase64'] ?: '',
                            'url' => @$row['_dlc_DocIdUrl'] ?: '',
                            'start_at' => dateTimeFromString(@$row['StarDate'])  ?: '',
                            'end_at' => dateTimeFromString(@$row['End_x0020_Date']) ?: '',
                        ];
                    })->toArray();
                    HseSafetyPoster::insert($itemData);
                }
            });
        }
    }
}
