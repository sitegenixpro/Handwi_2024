<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddFieldsToTempServiceOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('temp_service_orders', function (Blueprint $table) {
            //
            $table->text("user_latitude")->nullable();
            $table->text("user_longitude")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('temp_service_orders', function (Blueprint $table) {
            //
            $table->dropColumn("user_latitude");
            $table->dropColumn("user_longitude");
        });
    }
}
