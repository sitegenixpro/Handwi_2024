<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActivityIdInBrand extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brand', function (Blueprint $table) {
            $table->unsignedBigInteger('activity_id')->nullable();
        });
        Schema::table('product', function (Blueprint $table) {
            $table->unsignedBigInteger('activity_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brand', function (Blueprint $table) {
            $table->dropColumn('activity_id');
        });
        Schema::table('product', function (Blueprint $table) {
            $table->dropColumn('activity_id');
        });
    }
}
