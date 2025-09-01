<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNameArToCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('category', 'name_ar')) {
            Schema::table('category', function (Blueprint $table) {
                $table->string('name_ar')->nullable()->after('name'); // Adjust 'after' as needed
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('category', 'name_ar')) {
            Schema::table('category', function (Blueprint $table) {
                $table->dropColumn('name_ar');
            });
        }
    }
}
