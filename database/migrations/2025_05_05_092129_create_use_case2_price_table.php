<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('use_case2_price', function (Blueprint $table) {
            $table->id();
            $table->string('code');        // e.g., stock, brent, wti
            $table->string('title');       // Display Name e.g., MEDC, BRENT, WTI
            $table->date('date');          // date of the price record
            $table->bigInteger('value');   // large integer value
            $table->integer('delta');      // delta value, can be negative
            $table->integer('percent');    // percent value, can be negative
            $table->timestamps();                  // created_at and updated_at
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('use_case2_price');
    }
    
};
