<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_type', function (Blueprint $table) {
            $table->id();
            $table->integer('account_id')->nullable();
            $table->string('name',600)->nullable();
            $table->string('description',600)->nullable();
            $table->string('logo')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('status')->default(1);
            $table->integer('availbale_for')->default(3)->comment('1-company,2-individual,3-both');
            $table->string('indvidual_name')->nullable();
            $table->text('indvidual_logo')->nullable();
            $table->integer('deleted')->default(0);
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
        Schema::dropIfExists('activity_type');
    }
}
