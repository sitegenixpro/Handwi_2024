<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArabicColumnsToProductSpecificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_specifications', function (Blueprint $table) {
            if (!Schema::hasColumn('product_specifications', 'title_ar')) {
                $table->string('title_ar')->nullable()->after('spec_title');
            }

            if (!Schema::hasColumn('product_specifications', 'description_ar')) {
                $table->text('description_ar')->nullable()->after('spec_descp');
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
        Schema::table('product_specifications', function (Blueprint $table) {
            if (Schema::hasColumn('product_specifications', 'title_ar')) {
                $table->dropColumn('title_ar');
            }

            if (Schema::hasColumn('product_specifications', 'description_ar')) {
                $table->dropColumn('description_ar');
            }
        });
    }
}
