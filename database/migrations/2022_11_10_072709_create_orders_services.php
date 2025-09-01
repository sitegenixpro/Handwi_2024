<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_services', function (Blueprint $table) {
            $table->bigIncrements('order_id');
            $table->string('invoice_id',600)->nullable();
            $table->integer('user_id')->default(0);
            $table->integer('address_id')->default(0);
            $table->double('total', 15, 2)->nullable();
            $table->double('vat', 15, 2)->nullable();
            $table->double('discount', 15, 2)->nullable();
            $table->double('grand_total', 15, 2)->nullable();
            $table->integer('payment_mode')->default(0);
            $table->integer('status')->default(0);
            $table->string('booking_date',600)->nullable();
            $table->double('admin_commission', 15, 2)->nullable();
            $table->double('vendor_commission', 15, 2)->nullable();
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
        Schema::dropIfExists('orders_services');
    }
}
