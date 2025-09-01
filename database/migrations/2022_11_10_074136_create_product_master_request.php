<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductMasterRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_master_request', function (Blueprint $table) {
            $table->id();
            $table->string('name',600)->nullable();
            $table->string('description',600)->nullable();
            $table->integer('vendor_id')->default(0);
            $table->integer('deleted')->default(0);
            $table->integer('accepted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_master_request');
    }
}
