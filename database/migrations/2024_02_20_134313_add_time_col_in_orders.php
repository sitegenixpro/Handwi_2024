<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimeColInOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string("pick_up_date")->nullable()->default('');
            $table->string("pick_up_time")->nullable()->default('');
        });
         Schema::table('temp_orders', function (Blueprint $table) {
            $table->string("pick_up_date")->nullable()->default('');
            $table->string("pick_up_time")->nullable()->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn("pick_up_date");
            $table->dropColumn("pick_up_time");
        });
        Schema::table('temp_orders', function (Blueprint $table) {
            $table->dropColumn('pick_up_date');
            $table->dropColumn('pick_up_time');
        });

    }
}
