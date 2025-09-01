<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartService extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_service', function (Blueprint $table) {
            $table->id();
            $table->integer('service_id')->default(0);
            $table->integer('user_id')->default(0);
            $table->string('device_cart_id',600)->nullable();
            $table->string('booked_time',600)->nullable();
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
        Schema::dropIfExists('cart_service');
    }
}
