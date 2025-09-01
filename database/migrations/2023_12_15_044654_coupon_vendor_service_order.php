<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CouponVendorServiceOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_vendor_service_order', function (Blueprint $table) {
            $table->id();
            $table->integer('vendor_id')->default(0);
            $table->integer('coupon_id')->default(0);
            $table->integer('order_id')->default(0);
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
        Schema::dropIfExists('coupon_vendor_service_order');
    }
}
