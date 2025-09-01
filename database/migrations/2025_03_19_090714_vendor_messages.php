<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VendorMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_messages', function (Blueprint $table) {
           // $table->text('is_type_gift',2000)->change();
            $table->string('user_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_messages', function (Blueprint $table) {
            $table->dropColumn('user_id',200);
           // $table->dropColumn('doc');
        });
    }
}
