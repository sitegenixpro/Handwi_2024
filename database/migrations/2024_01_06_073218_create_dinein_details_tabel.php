<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDineinDetailsTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('is_dinein')->default(0);
            $table->integer('is_delivery')->default(0);
        });
        Schema::create('vendor_menu_images', function (Blueprint $table) {
            $table->id();
            $table->integer('vendor_id')->default(0);
            $table->string('image')->default('');
            $table->timestamps();
        });

        Schema::create('cuisines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('status')->default(1);
            $table->integer('deleted')->default(0);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('vendor_cuisines', function (Blueprint $table) {
            $table->id();
            $table->integer('vendor_id')->default(0);
            $table->integer('cuisine_id')->default(0);
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_dinein');
            $table->dropColumn('is_delivery');
            //
        });
        Schema::dropIfExists('vendor_menu_images');
        Schema::dropIfExists('cuisines');
        Schema::dropIfExists('vendor_cuisines');

    }
}
