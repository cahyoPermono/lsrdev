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
        Schema::table('use_case2_company_chart_data',function(Blueprint $table){
            $table->dropColumn('actual');
            $table->dropColumn('budget');
            $table->dropColumn('outlook');
            $table->string('date_label',8)->index('date_label_use_case2_company_chart_data')->nullable();
            $table->double('actual_net')->nullable();
            $table->double('actual_gross')->nullable();
            $table->double('budget_net')->nullable();
            $table->double('budget_gross')->nullable();
            $table->double('outlook_net')->nullable();
            $table->double('outlook_gross')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
