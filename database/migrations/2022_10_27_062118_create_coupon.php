<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoupon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon', function (Blueprint $table) {
            $table->id();
            $table->string('coupon_title',600)->nullable();
            $table->longText('coupon_description')->nullable();
            $table->dateTime('coupon_end_date')->nullable();
            $table->double('coupon_amount', 15, 2)->nullable();
            $table->double('coupon_minimum_spend', 15, 2)->nullable();
            $table->double('coupon_max_spend', 15, 2)->nullable();
            $table->double('coupon_usage_percoupon', 15, 2)->nullable();
            $table->double('coupon_usage_perx', 15, 2)->nullable();
            $table->double('coupon_usage_peruser', 15, 2)->nullable();
            $table->integer('coupon_vender_id')->default(0);
            $table->integer('coupon_status')->default(0);
            $table->integer('deleted')->default(0);
            $table->string('coupon_code',100)->nullable();
            $table->integer('amount_type')->default(0);
            $table->string('start_date',600)->nullable();
            $table->integer('applied_to')->default(0);
            $table->double('minimum_amount', 15, 2)->nullable();
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
        Schema::dropIfExists('coupon');
    }
}
