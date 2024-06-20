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
        Schema::create('hse_popup_campaigns', function (Blueprint $table) {
            $table->id();
            $table->longText('file');
            $table->string('title');
            $table->text('description');
            $table->string('url');
            $table->string('keyword');
            $table->string('author');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hse_popup_campaigns');
    }
};
