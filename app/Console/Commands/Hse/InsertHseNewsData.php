<?php

namespace App\Console\Commands\Hse;

use App\Helpers\MedcoRestful;
use App\Helpers\Url;
use App\Models\Hse\HseNews;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertHseNewsData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hse:insert-hse-news';

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
            url : Url::GetHseNews
        );
        if ($itemData) {
            DB::transaction(function () use ($itemData) {
                HseNews::query()->delete();
                $items = collect($itemData)->chunk(200);
                foreach ($items as $data) {
                    $itemData = $data->map(function ($row){
                        return [
                            'title_en' => @$row['Title'],
                            'title_id' => @$row['Title_x0020__x002d__x0020_ID'],
                            'file' => @$row['FileBase64'] ?: '',
                            'contributor' => @$row['Contributor'] ?: '',
                            'date' => dateTimeFromString(@$row['Publication_x0020_Date']) ?: '',
                            'content_en' => @$row['Body'] ?: '',
                            'content_id' => @$row['Content_x0020__x002d__x0020_ID'] ?: '',
                        ];
                    })->toArray();
                    HseNews::insert($itemData);
                }
            });
        }
    }
}
