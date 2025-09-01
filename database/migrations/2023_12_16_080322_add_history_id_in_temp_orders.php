<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHistoryIdInTempOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('temp_orders', function (Blueprint $table) {
            $table->string('ref_history_id')->nullable()->default('0');
            $table->string('ref_code')->nullable()->default('');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->string('ref_history_id')->nullable()->default('0');
            $table->string('ref_code')->nullable()->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('temp_orders', function (Blueprint $table) {
            $table->dropColumn('ref_history_id');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('ref_history_id');
            $table->dropColumn('ref_code');
        });
    }
}
