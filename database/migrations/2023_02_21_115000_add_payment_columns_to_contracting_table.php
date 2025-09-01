<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentColumnsToContractingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contracting', function (Blueprint $table) {
            $table->string('transaction_id')->nullable();
            $table->string('payment_ref')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contracting', function (Blueprint $table) {
            $table->dropColumn('transaction_id');
            $table->dropColumn('payment_ref');
        });
    }
}
