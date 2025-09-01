<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalFieldsToStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->string('bank_country')->nullable();
            $table->string('tax_seller_type')->nullable();
            $table->string('residence_country')->nullable();
            $table->string('dob_day')->nullable();
            $table->string('dob_month')->nullable();
            $table->string('dob_year')->nullable();
            $table->string('shop_currency')->nullable();
            $table->string('shop_language')->nullable();
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
                'bank_country',
                'tax_seller_type',
                'residence_country',
                'dob_day',
                'dob_month',
                'dob_year',
                'shop_currency',
                'shop_language',
            ]);
        });
    }
}
