<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceTimingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_timings', function (Blueprint $table) {
            $table->id();
            $table->integer("vendor_id")->default(0);
            $table->integer("has_24_hour")->default(0);
            $table->integer("service_id")->default(0);
            $table->string("day");
            $table->string("time_from")->nullable();
            $table->string("time_to")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_timings');
    }
}
