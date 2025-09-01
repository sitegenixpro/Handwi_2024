<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersServicesItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_services_items', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->default(0);
            $table->integer('service_id')->default(0);
            $table->double('price', 15, 2)->nullable();
            $table->double('discount', 15, 2)->nullable();
            $table->double('total', 15, 2)->nullable();
            $table->double('order_status', 15, 2)->nullable();
            $table->double('admin_commission', 15, 2)->nullable();
            $table->double('vendor_commission', 15, 2)->nullable();
            $table->string('booking_date',600)->nullable();
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
        Schema::dropIfExists('orders_services_items');
    }
}
