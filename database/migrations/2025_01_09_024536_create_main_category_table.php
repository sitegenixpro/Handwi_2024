<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMainCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main_category', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('sub_title')->nullable();
            $table->string('image')->nullable();
            $table->string('button_link')->nullable();
            $table->integer('deleted')->default(0); // integer type with default 0
            $table->integer('active')->default(0); // integer type with default 0
            $table->timestamps(); // for created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('main_category');
    }
}
