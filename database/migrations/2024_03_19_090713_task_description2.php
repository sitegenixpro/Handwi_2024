<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TaskDescription2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders_services', function (Blueprint $table) {
            $table->string('task_description',600)->nullable();
            $table->string('doc',600)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders_services', function (Blueprint $table) {
            $table->dropColumn('task_description');
            $table->dropColumn('doc');
        });
    }
}
