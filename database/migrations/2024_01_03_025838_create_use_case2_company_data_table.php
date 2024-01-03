<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('use_case2_company_data', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->enum('type', ['sales', 'production'])->index();
            $table->date('date')->index();
            $table->string('code', 150);
            $table->string('name', 150);
            $table->string('country_code', 50);
            $table->json('gas_net');
            $table->json('gas_gross');
            $table->json('oil_net');
            $table->json('oil_gross');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('use_case2_company_data');
    }
};
