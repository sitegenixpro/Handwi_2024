<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTaxAddressColumnsToStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->string('tax_number', 15)->nullable();
            $table->string('tax_street', 255)->nullable();
            $table->string('tax_address_line_2', 255)->nullable();
            $table->string('tax_city', 100)->nullable();
            $table->string('tax_state', 100)->nullable();
            $table->string('tax_post_code', 10)->nullable();
            $table->string('tax_phone', 15)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn([
                'tax_number',
                'tax_street',
                'tax_address_line_2',
                'tax_city',
                'tax_state',
                'tax_post_code',
                'tax_phone',
            ]);
        });
    }
}
