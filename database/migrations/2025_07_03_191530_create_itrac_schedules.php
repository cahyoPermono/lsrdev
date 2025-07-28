<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('itrac_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('from_location');
            $table->string('to_location');
            $table->time('departure_time');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('itrac_schedules');
    }
};
