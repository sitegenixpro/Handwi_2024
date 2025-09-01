<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CouponCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons_category', function (Blueprint $table) {
            $table->id();
            $table->string('name',600)->nullable();
            $table->string('image',600)->nullable();
            $table->string('banner_image',600)->nullable();
            $table->integer('parent_id')->default(0);
            $table->integer('active')->default(0);
            $table->integer('deleted')->default(0);
            $table->integer('sort_order')->default(0);
            $table->integer('created_uid')->default(0);
            $table->integer('updated_uid')->default(0);
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
        Schema::dropIfExists('coupon_category');
    }
}
