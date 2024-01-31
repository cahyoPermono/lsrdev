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
        Schema::create('use_case2_block_summary', function (Blueprint $table) {
            $table->id();
            $table->date('date')->index();
            $table->string('asset_code',70)->index();
            $table->string('code',70)->index()->nullable();
            $table->json('gross');
            $table->json('net');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('use_case2_block_summary');
    }
};
