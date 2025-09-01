<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptionArToProductFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_features', function (Blueprint $table) {
            if (!Schema::hasColumn('product_features', 'description_ar')) {
                $table->text('description_ar')->nullable()->after('description');
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
         Schema::table('product_features', function (Blueprint $table) {
            if (Schema::hasColumn('product_features', 'description_ar')) {
                $table->dropColumn('description_ar');
            }
        });
    }
}
