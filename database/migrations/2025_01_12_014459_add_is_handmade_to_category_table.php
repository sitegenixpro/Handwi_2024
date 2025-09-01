<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsHandmadeToCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category', function (Blueprint $table) {
            Schema::table('category', function (Blueprint $table) {
                if (!Schema::hasColumn('category', 'is_handmade')) {
                    $table->boolean('is_handmade')->default(0); // Replace 'existing_column_name' with the column after which you want to add this
                }
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
        Schema::table('category', function (Blueprint $table) {
            Schema::table('category', function (Blueprint $table) {
                if (Schema::hasColumn('category', 'is_handmade')) {
                    $table->dropColumn('is_handmade');
                }
            });
        });
    }
}
