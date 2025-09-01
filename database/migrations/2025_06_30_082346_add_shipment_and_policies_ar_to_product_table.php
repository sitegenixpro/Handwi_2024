<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShipmentAndPoliciesArToProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product', function (Blueprint $table) {
            if (!Schema::hasColumn('product', 'shipment_and_policies_ar')) {
                $table->text('shipment_and_policies_ar')->nullable()->after('shipment_and_policies');
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
                $table->dropColumn('shipment_and_policies_ar');
            }
        });
    }
}
