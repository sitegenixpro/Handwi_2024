<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerNotesAndCustomerFileToTempOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('temp_order_products', function (Blueprint $table) {
            $table->text('customer_notes')->nullable();

            // Add 'customer_file' as a string to store file paths/URLs (nullable)
            $table->text('customer_file')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('temp_order_products', function (Blueprint $table) {
            $table->dropColumn('customer_notes');
            $table->dropColumn('customer_file');
        });
    }
}
