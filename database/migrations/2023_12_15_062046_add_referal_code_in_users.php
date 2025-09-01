<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReferalCodeInUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('ref_code')->nullable()->default('');
        });

        Schema::create('ref_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id')->default(0);
            $table->unsignedBigInteger('accepted_user_id')->default(0);
            $table->string('name')->nullable();
            $table->string('ref_code')->nullable();
            $table->integer('status')->default(0);
            $table->integer('discount')->nullable()->default(0);
            $table->string('discount_type')->nullable()->default('1');
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });

        Schema::table('contact_us_settings', function (Blueprint $table) {
            $table->integer('ref_discount')->nullable()->default(0);
            $table->string('ref_discount_type')->nullable()->default('1');
        });
        

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('ref_code');
        });
        Schema::dropIfExists('ref_history');

        Schema::table('contact_us_settings', function (Blueprint $table) {
            $table->dropColumn('ref_discount');
            $table->dropColumn('ref_discount_type');
        });
    }
}
