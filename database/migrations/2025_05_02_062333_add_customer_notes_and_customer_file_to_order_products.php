<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerNotesAndCustomerFileToOrderProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_products', function (Blueprint $table) {
            $table->text('customer_notes')->nullable()->after('total');
            
            // Adding the customer_file column (nullable string for file path)
            $table->text('customer_file')->nullable()->after('customer_notes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_products', function (Blueprint $table) {
            $table->dropColumn('customer_notes');
            $table->dropColumn('customer_file');
        });
    }
}
