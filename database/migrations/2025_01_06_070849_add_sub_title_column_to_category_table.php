<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubTitleColumnToCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category', function (Blueprint $table) {
            if (!Schema::hasColumn('category', 'sub_title')) {
                Schema::table('category', function (Blueprint $table) {
                    // Add the 'sub_title' column to the 'category' table
                    $table->string('sub_title')->nullable()->after('home_page');  // Adjust 'after' as per your table structure
                });
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
            if (Schema::hasColumn('category', 'sub_title')) {
                Schema::table('category', function (Blueprint $table) {
                    $table->dropColumn('sub_title');
                });
            }
        });
    }
}
