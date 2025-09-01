<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempServiceOrderItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_service_order_items', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->default(0);
            $table->integer('service_id')->default(0);
            $table->double('price', 15, 2);
            $table->double('discount', 15, 2);
            $table->double('total', 15, 2);
            $table->double('admin_commission', 15, 2);
            $table->double('vendor_commission', 15, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temp_service_order_items');
    }
}
