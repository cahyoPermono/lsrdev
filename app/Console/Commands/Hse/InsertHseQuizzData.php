<?php

namespace App\Console\Commands\Hse;

use App\Helpers\MedcoRestful;
use App\Helpers\Url;
use App\Models\Hse\HseQuizz;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertHseQuizzData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hse:insert-hse-quizz';

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
                HseQuizz::query()->delete();
                $items = collect($itemData)->chunk(200);
                foreach ($items as $data) {
                    $itemData = $data->map(function ($row){
                        return [
                            'title' => @$row['Title'],
                            'url' => @$row['Link'] ?: '',
                            'author' => @$row['Author'] ?: '',
                            'file' => @$row['FileBase64'] ?: '',
                            'start_at' => dateTimeFromString(@$row['Start_x0020_Date']) ?: '',
                            'end_at' => dateTimeFromString(@$row['End_x0020_Date']) ?: '',
                        ];
                    })->toArray();
                    HseQuizz::insert($itemData);
                }
            });
        }
    }
}
