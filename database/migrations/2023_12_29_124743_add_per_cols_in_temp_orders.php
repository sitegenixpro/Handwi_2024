<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPerColsInTempOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('temp_orders', function (Blueprint $table) {
            $table->string('admin_commission_percentage')->nullable()->default('0');
            $table->string('vendor_commission_percentage')->nullable()->default('0');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->string('admin_commission_percentage')->nullable()->default('0');
            $table->string('vendor_commission_percentage')->nullable()->default('0');
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
            $table->dropColumn('admin_commission_percentage');
            $table->dropColumn('vendor_commission_percentage');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('admin_commission_percentage');
            $table->dropColumn('vendor_commission_percentage');
        });
    }
}
