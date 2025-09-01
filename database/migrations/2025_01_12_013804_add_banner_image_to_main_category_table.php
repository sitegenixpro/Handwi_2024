<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBannerImageToMainCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('main_category', function (Blueprint $table) {
            Schema::table('main_category', function (Blueprint $table) {
                $table->string('banner_image')->nullable(); // Add 'after' if you want to specify position
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('main_category', function (Blueprint $table) {
            Schema::table('main_category', function (Blueprint $table) {
                $table->dropColumn('banner_image');
            });
        });
    }
}
