<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateVendorDetailsColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_details', function (Blueprint $table) {
            // Use raw SQL to drop the columns
            DB::statement('ALTER TABLE vendor_details DROP COLUMN IF EXISTS city');
            DB::statement('ALTER TABLE vendor_details DROP COLUMN IF EXISTS state');
    
            // Add new columns
            $table->string('country')->nullable()->default('0');
            $table->string('city')->nullable()->default('0');
            $table->string('street1')->nullable()->default('0');
            $table->string('street2')->nullable()->default('0');
            $table->string('state')->nullable()->default('0');
            $table->string('postal_code')->nullable()->default('0');
            $table->string('phone_number')->nullable()->default('0');
        });
    }
    
    
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_details', function (Blueprint $table) {
            $table->integer('city')->nullable()->default(0);
            $table->integer('state')->nullable()->default(0);

            // Drop the newly added columns
            $table->dropColumn('country');
            $table->dropColumn('street1');
            $table->dropColumn('street2');
            $table->dropColumn('postal_code');
            $table->dropColumn('phone_number');
        });
    }
}
