<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeliveryFieldsToStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->string('delivery_type')->nullable();
            $table->string('standard_delivery_text')->nullable();
            $table->integer('delivery_min_days')->nullable();
            $table->integer('delivery_max_days')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn(['delivery_type', 'standard_delivery_text', 'delivery_min_days', 'delivery_max_days']);
        });
    }
}
