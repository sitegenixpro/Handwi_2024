<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Coupons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('title',600)->nullable();
            $table->string('title_ar',600)->nullable();
            $table->integer('brand_id')->default(0);
            $table->integer('category_id')->default(0);
            $table->string('coupon_code',600)->nullable();
            $table->integer('active')->default(0);
            $table->integer('sort_order')->default(0);
            $table->integer('trending')->default(0);
            $table->integer('hot_deal')->default(0);
            $table->longText('description')->nullable();
            $table->longText('description_ar')->nullable();
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
        Schema::dropIfExists('coupons');
    }
}
