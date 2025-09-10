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
        Schema::create('use_case2_company_ytd_production_breakdown', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('country_code');
            $table->string('type'); // gas, oil, total
            $table->enum('working_interest', ['gross', 'nett']);
            $table->decimal('ytd_production', 16, 2)->nullable();
            $table->decimal('budget', 16, 2)->nullable();
            $table->decimal('delta', 16, 2)->nullable();
            $table->decimal('percent', 5, 2)->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('use_case2_company_ytd_production_breakdown');
    }
};
