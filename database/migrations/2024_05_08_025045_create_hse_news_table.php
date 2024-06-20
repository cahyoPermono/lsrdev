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
        Schema::create('hse_news', function (Blueprint $table) {
            $table->id();
            $table->string('title_en')->nullable();
            $table->string('title_id')->nullable();
            $table->longText('file');
            $table->string('contributor');
            $table->dateTime('date');
            $table->longText('content_en')->nullable();
            $table->longText('content_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hse_news');
    }
};
