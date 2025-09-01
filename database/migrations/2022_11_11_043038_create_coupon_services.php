<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_services', function (Blueprint $table) {
            $table->id();
            $table->integer('coupon_id')->default(0);
            $table->integer('service_id')->default(0);
        });
        DB::table('coupon_services')->insert(
        [
          [
            'service_id' => 1,
            'coupon_id' => 1
          ]
       ]
       );
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupon_services');
    }
}
