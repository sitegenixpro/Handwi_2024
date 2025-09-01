<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Banner1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('app_banners', function (Blueprint $table) {
           // $table->text('is_type_gift',2000)->change();
            $table->string('is_type_gift')->nullable();

           

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('app_banners', function (Blueprint $table) {
            $table->dropColumn('is_type_gift',200);
           // $table->dropColumn('doc');
        });
    }
}
