<?php

namespace App\Console\Commands\Hse;

use App\Helpers\MedcoRestful;
use App\Helpers\Url;
use App\Models\Hse\HseEvent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertHseCalendarEventData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hse:insert-hse-calendar-event';

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
            url : Url::GetHseCalendarEvent
        );
        HseEvent::query()->delete();
        if ($itemData) {
            DB::transaction(function () use ($itemData) {
                $items = collect($itemData)->chunk(200);
                foreach ($items as $data) {
                    $itemData = $data->map(function ($row){
                        return [
                            'title' => @$row['Title'] ?: '',
                            'author' => @$row['Author'] ?: '',
                            'description' => @$row['Description'] ?: '',
                            'location' => @$row['Location'] ?: '',
                            'category' => @$row['Category'] ?: '',
                            'file' => @$row['FileBase64'] ?: '',
                            'participant' => @$row['ParticipantsPicker'] ?: '',
                            'start_at' => dateTimeFromString(@$row['EventDate']) ?: '',
                            'end_at' => dateTimeFromString(@$row['EndDate']) ?: '',
                        ];
                    })->toArray();
                    HseEvent::insert($itemData);
                }
            });
        }
    }

}
