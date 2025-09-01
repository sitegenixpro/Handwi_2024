<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TaskDescription1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('temp_service_orders', function (Blueprint $table) {
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
        Schema::table('temp_service_orders', function (Blueprint $table) {
            $table->dropColumn('task_description');
            $table->dropColumn('doc');
          });
    }
}
