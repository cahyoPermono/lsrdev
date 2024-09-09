<?php

namespace App\Console\Commands\Hse;

use App\Helpers\MedcoRestful;
use App\Helpers\Url;
use App\Models\Hse\HseDocument;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertHseDocumentData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hse:insert-hse-document';

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
            url : Url::GetHseDocument
        );
        HseDocument::query()->delete();
        if ($itemData) {
            DB::transaction(function () use ($itemData) {
                $items = collect($itemData)->chunk(200);
                foreach ($items as $data) {
                    $itemData = $data->map(function ($row){
                        return [
                            'name' => @$row['Document_x0020_Number'] ?: '',
                            'description' => @$row['Document_x0020_Description'] ?: '',
                            'author' => @$row['Author'] ?: '',
                            'start_at' => dateTimeFromString(@$row['Start_x0020_Date']) ?: '',
                            'end_at' => dateTimeFromString(@$row['End_x0020_Date']) ?: '',
                        ];
                    })->toArray();
                    HseDocument::insert($itemData);
                }
            });
        }
    }
}
