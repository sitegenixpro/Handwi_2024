<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNameArToCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('country', function (Blueprint $table) {
            if (!Schema::hasColumn('country', 'name_ar')) {
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
        Schema::table('country', function (Blueprint $table) {
            if (Schema::hasColumn('country', 'name_ar')) {
                $table->dropColumn('name_ar');
            }
        });
    }
}
