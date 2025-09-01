<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArabicFieldsToMainCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('main_category', function (Blueprint $table) {
            if (!Schema::hasColumn('main_category', 'name_ar')) {
                $table->string('name_ar')->nullable()->after('name');
            }
            if (!Schema::hasColumn('main_category', 'sub_title_ar')) {
                $table->string('sub_title_ar')->nullable()->after('sub_title');
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
        Schema::table('main_category', function (Blueprint $table) {
            if (Schema::hasColumn('main_category', 'name_ar')) {
                $table->dropColumn('name_ar');
            }
            if (Schema::hasColumn('main_category', 'sub_title_ar')) {
                $table->dropColumn('sub_title_ar');
            }
        });
    }
}
