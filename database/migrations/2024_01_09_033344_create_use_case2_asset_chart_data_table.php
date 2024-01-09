<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('use_case2_asset_chart_data', function (Blueprint $table) {
            $table->id();
            $table->date('date')->index();
            $table->string('company_code')->index();
            $table->json('actual');
            $table->json('budget');
            $table->json('outlook');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('use_case2_asset_chart_data');
    }
};
