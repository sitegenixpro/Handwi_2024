<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Text3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders_services_items', function (Blueprint $table) {
            $table->string('text',600)->nullable();
            $table->double('hourly_rate', 15, 2)->default(0);
            $table->longText('task_description')->nullable();
            $table->string('doc',600)->nullable();
            $table->integer('qty')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders_services_items', function (Blueprint $table) {
            //
        });
    }
}
