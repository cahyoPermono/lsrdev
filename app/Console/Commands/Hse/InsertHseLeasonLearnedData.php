<?php

namespace App\Console\Commands\Hse;

use App\Helpers\MedcoRestful;
use App\Helpers\Url;
use App\Models\Hse\HseLeasonLearned;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertHseLeasonLearnedData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hse:insert-hse-leason-learned';

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
            url : Url::GetHseLeassonLearned
        );
        if ($itemData) {
            DB::transaction(function () use ($itemData) {
                HseLeasonLearned::query()->delete();
                $items = collect($itemData)->chunk(200);
                foreach ($items as $data) {
                    $itemData = $data->map(function ($row){
                        return [
                            'title' => @$row['Title'] ?: '',
                            'description' => @$row['Incident_x0020_Description'] ?: '',
                            'file' => @$row['FileBase64'] ?: '',
                            'incident_time' => dateTimeFromString(@$row['Incident_x0020_Time']) ?: '',
                            'risk_ranking' => @$row['Risk_x0020_Ranking'] ?: '',
                            'incident_location' => @$row['Incident_x0020_Location'] ?: '',
                            'leason_learned' => @$row['Body'] ?: '',
                            'asset_action' => @$row['Asset_x0020_Actions'] ?: '',
                        ];
                    })->toArray();
                    HseLeasonLearned::insert($itemData);
                }
            });
        }
    }
}
