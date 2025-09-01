<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_banners', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable(); // Column for name
            $table->text('description')->nullable(); // Column for description
            $table->string('banner_image', 600)->nullable(); // Column for banner image
            $table->string('button_link')->nullable(); // Column for button link
            $table->integer('active')->default(1)->nullable(); // Column for active status
            $table->integer('deleted')->default(0)->nullable(); // Column for deleted status
            $table->timestamps(); // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('web_banners');
    }
}
