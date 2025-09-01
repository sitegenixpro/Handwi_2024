<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_banners', function (Blueprint $table) {
            $table->id();
            $table->string("banner_title")->nullable();
            $table->text("banner_image");
            $table->integer("active")->default(1);
            $table->integer("created_by")->default(0);
            $table->integer("updated_by")->default(0);
            $table->integer("type")->default(1)->nullable();
            $table->text("category")->nullable();
            $table->text("product")->nullable();
            $table->text("service")->nullable();
            $table->integer("banner_type")->default(1)->nullable();
            $table->integer("activity")->default(0);
            $table->integer("store")->default(0);
            $table->text("url")->nullable();
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
        Schema::dropIfExists('custom_banners');
    }
}
