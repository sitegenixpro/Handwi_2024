<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempServiceOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_service_orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id',600)->nullable();
            $table->integer('user_id')->default(0);
            $table->integer('address_id')->default(0);
            $table->double('total', 15, 2)->nullable();
            $table->double('vat', 15, 2)->nullable();
            $table->double('discount', 15, 2)->nullable();
            $table->double('grand_total', 15, 2)->nullable();
            $table->integer('payment_mode')->default(0);
            $table->double('admin_commission', 15, 2)->nullable();
            $table->double('vendor_commission', 15, 2)->nullable();
            $table->string('temp_id',600)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temp_service_orders');
    }
}
