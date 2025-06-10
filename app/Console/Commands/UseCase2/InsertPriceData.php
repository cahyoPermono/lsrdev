<?php

namespace App\Console\Commands\UseCase2;

use Exception;
use App\Helpers\MedcoRestful;
use App\Helpers\Url;
use App\Models\UseCase2\UseCase2Price;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertPriceData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'use-case-2:insert-price-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Use Case 2 - Insert Price Data [1]';

    /**
     * Execute the console command.
     */
    public function handle(): void {
        self::fetchAndInsertPrice(Url::GetMedcoStockPrice, 'stock', 'MEDC');
        self::fetchAndInsertPrice(Url::GetCrudeBrentStockPrice, 'brent', 'Brent');
        self::fetchAndInsertPrice(Url::GetWTIPrice, 'wti', 'WTI');
    }

    public function fetchAndInsertPrice(string $url, string $code, string $name): void{
        $data = MedcoRestful::fetchData(
            url: $url
        );
        if ($data) {
            DB::transaction(function () use ($data, $code, $name) {
                // Insert the new record
                $newRecord = UseCase2Price::create([
                    'code' => $code,
                    'title' => $name,
                    'date' => date('Y-m-d H-i-s', strtotime($data['Date'])),
                    'value' => $data['Value'],
                    'delta' => $data['Change'] ?? $data['Delta'],
                    'percent' => $data['PCT'],
                ]);
    
                // Delete all previous records except the newly inserted one
                UseCase2Price::where('code', $code)
                    ->where('id', '<>', $newRecord->id)
                    ->delete();
            });
        }
    }
}
