<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Service26 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service', function (Blueprint $table) {
            $table->text('term_and_condition',2000)->change();

           

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
