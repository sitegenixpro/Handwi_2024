<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('service_id')->default(0)->nullable();
            $table->integer('user_id')->default(0)->nullable();
            $table->integer('vendor_id')->default(0)->nullable();
            $table->integer('seat_no')->default(0)->nullable();
            $table->string('status', 255)->nullable(); // Column for name
            $table->string('payment_type', 255)->nullable();
            $table->string('price', 255)->nullable();
            $table->string('service_charge', 255)->nullable();
            $table->string('Workshop_price', 255)->nullable();
            $table->string('tax', 255)->nullable();
            $table->string('grand_total', 255)->nullable();
            $table->string('ref_id', 255)->nullable();
            $table->timestamps(); // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_bookings');
    }
}
