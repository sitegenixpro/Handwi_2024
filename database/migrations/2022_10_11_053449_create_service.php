<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateService extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service', function (Blueprint $table) {
            $table->id();
            $table->string('name',600)->nullable();
            $table->string('image',600)->nullable();
            $table->integer('category')->default(0);
            $table->foreign('category')
            ->references('id')
            ->on('service_category')
            ->onDelete('cascade');
            $table->double('service_price', 15, 2)->nullable();
            $table->integer('active')->default(0);
            $table->integer('deleted')->default(0);
            $table->integer('order')->default(0);
            $table->string('description',600)->nullable();
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
        Schema::dropIfExists('service');
    }
}
