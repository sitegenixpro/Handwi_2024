<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Service25 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service', function (Blueprint $table) {
            $table->string('to_time',200)->nullable();
            $table->string('from_time',200)->nullable();
            $table->string('location',200)->nullable();
            $table->string('latitude',200)->nullable();
            $table->string('longitude',200)->nullable();
            $table->integer('vendor_id')->nullable();

           

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service', function (Blueprint $table) {
            $table->dropColumn('to_time',200);
            $table->dropColumn('from_time',200);
            $table->dropColumn('location',200);
            $table->dropColumn('latitude',200);
            $table->dropColumn('longitude',200);
            $table->dropColumn('vendor_id');
           // $table->dropColumn('doc');
        });
    }
}
