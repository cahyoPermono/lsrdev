<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUseCase2PriceChangeIntegerToDecimal extends Migration
{
    public function up()
    {
        Schema::table('use_case2_price', function (Blueprint $table) {
            $table->decimal('value', 20, 4)->change();
            $table->decimal('delta', 10, 4)->change();
            $table->decimal('percent', 5, 2)->change();
        });
    }

    public function down()
    {
        Schema::table('use_case2_price', function (Blueprint $table) {
            $table->bigInteger('value')->change();
            $table->integer('delta')->change();
            $table->integer('percent')->change();
        });
    }
}
