<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceToMaintainance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('maintainance', function (Blueprint $table) {
             $table->double('price')->nullable();
            $table->string('qoutation_file')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('maintainance', function (Blueprint $table) {
             $table->dropColumn('price');
            $table->dropColumn('qoutation_file');
        });
    }
}
