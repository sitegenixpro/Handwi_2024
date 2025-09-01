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
        Schema::create('reported_shops', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');         // ID of the user who reports
            $table->bigInteger('shop_id');       // ID of the artist being reported
            $table->bigInteger('reason_id')->nullable(); // ID of the report reason
            $table->text('description')->nullable();  // Additional description of the report
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reported_shops');
    }
};
