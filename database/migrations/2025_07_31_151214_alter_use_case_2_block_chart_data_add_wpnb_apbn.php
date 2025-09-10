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
        Schema::table('use_case2_block_chart_data',function(Blueprint $table){
            $table->renameColumn('asset_code', 'block_name');
            $table->index(['date', 'type']);
            $table->string('asset_kind')->nullable();
            $table->double('wpnb_gross')->nullable();
            $table->double('wpnb_net')->nullable();
            $table->double('apbn_gross')->nullable();
            $table->double('apbn_net')->nullable();
            $table->dropColumn('date_label');
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
