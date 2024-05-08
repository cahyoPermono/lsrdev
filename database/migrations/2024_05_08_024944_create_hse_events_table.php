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
        Schema::create('hse_events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('location');
            $table->text('description');
            $table->string('category');
            $table->longText('file');
            $table->text('participant')->nullable();
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
        Schema::dropIfExists('hse_events');
    }
};
