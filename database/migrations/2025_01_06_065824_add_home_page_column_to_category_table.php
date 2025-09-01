<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHomePageColumnToCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category', function (Blueprint $table) {
            if (!Schema::hasColumn('category', 'home_page')) {
                $table->boolean('home_page')->default(0)->after('existing_column_name'); // Adjust 'existing_column_name' as needed
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
        Schema::table('category', function (Blueprint $table) {
            if (Schema::hasColumn('category', 'home_page')) {
                $table->dropColumn('home_page');
            }
        });
    }
}
