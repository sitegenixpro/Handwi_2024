<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductChecks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->string('new_arrival')->nullable();
            $table->string('for_you')->nullable();
            $table->string('trending')->nullable();
           // $table->string('doc',600)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->dropColumn('new_arrival');
            $table->dropColumn('for_you');

            $table->dropColumn('trending');

           // $table->dropColumn('doc');
        });
    }
}
