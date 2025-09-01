<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArabicColumnsToProductRelatedTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product', function (Blueprint $table) {
            if (Schema::hasColumn('product', 'shipment_and_policies_ar')) {
                $table->text('shipment_and_policies_ar')->nullable()->change(); // Make nullable if not already
            }
        });

        // Add new Arabic description columns
        Schema::table('product_selected_attribute_list', function (Blueprint $table) {
            if (!Schema::hasColumn('product_selected_attribute_list', 'product_desc_short_arabic')) {
                $table->text('product_desc_short_arabic')->nullable();
            }
            if (!Schema::hasColumn('product_selected_attribute_list', 'product_desc_full_arabic')) {
                $table->text('product_desc_full_arabic')->nullable();
            }
        });

        // Add title_ar to product_specifications
        Schema::table('product_specifications', function (Blueprint $table) {
            if (!Schema::hasColumn('product_specifications', 'title_ar')) {
                $table->string('title_ar')->nullable();
            }
        });

        // Add feature_title_ar to product_product_feature
        Schema::table('product_product_feature', function (Blueprint $table) {
            if (!Schema::hasColumn('product_product_feature', 'feature_title_ar')) {
                $table->string('feature_title_ar')->nullable()->after('feature_title');
            }
        });

        // Add description_ar (you didn’t mention table, assuming `product`)
        Schema::table('product', function (Blueprint $table) {
            if (!Schema::hasColumn('product', 'description_ar')) {
                $table->text('description_ar')->nullable();
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
         Schema::table('product', function (Blueprint $table) {
            if (Schema::hasColumn('product', 'shipment_and_policies_ar')) {
                $table->text('shipment_and_policies_ar')->nullable()->change();
            }
            if (Schema::hasColumn('product', 'description_ar')) {
                $table->dropColumn('description_ar');
            }
        });

        Schema::table('product_selected_attribute_list', function (Blueprint $table) {
            $table->dropColumn('product_desc_short_arabic');
            $table->dropColumn('product_desc_full_arabic');
        });

        Schema::table('product_specifications', function (Blueprint $table) {
            $table->dropColumn('title_ar');
        });

        Schema::table('product_product_feature', function (Blueprint $table) {
            $table->dropColumn('feature_title_ar');
        });
    }
}
