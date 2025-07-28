<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('itrac_utility', function (Blueprint $table) {
            $table->string('value')->change();
        });
    }

    public function down()
    {
        Schema::table('itrac_utility', function (Blueprint $table) {
            $table->integer('value')->change();
        });
    }
};