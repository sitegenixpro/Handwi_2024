<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategorypro extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotion_banners', function (Blueprint $table) {
            $table->integer('type')->default(0);
            $table->integer('product')->default(0);
            $table->integer('service')->default(0);
            $table->integer('banner_type')->default(0);
            $table->integer('activity')->default(0);
            $table->integer('store')->default(0);
            $table->integer('category')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promotion_banners', function (Blueprint $table) {
            //
        });
    }
}
