<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNameArToBrandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('brand', function (Blueprint $table) {
            if (!Schema::hasColumn('brand', 'name_ar')) {
                $table->string('name_ar')->nullable()->after('name');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brand', function (Blueprint $table) {
            if (Schema::hasColumn('brand', 'name_ar')) {
                $table->dropColumn('name_ar');
            }
        });
    }
}
