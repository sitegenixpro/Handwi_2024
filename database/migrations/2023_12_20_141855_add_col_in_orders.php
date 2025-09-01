<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColInOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('vendor_id')->nullable()->deafult('0');
            $table->string('admin_commission_per')->nullable()->deafult('0');
            $table->string('vendor_commission_per')->nullable()->deafult('0');
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
            $table->dropColumn('vendor_id');
            $table->dropColumn('admin_commission_per');
            $table->dropColumn('vendor_commission_per');
        });
    }
}
