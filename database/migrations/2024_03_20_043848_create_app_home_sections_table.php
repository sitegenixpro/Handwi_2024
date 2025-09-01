<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppHomeSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_home_sections', function (Blueprint $table) {
            $table->id();
            $table->string("type");
            $table->integer("entity_id")->default(0);
            $table->string("title")->nullable();
            $table->integer("status")->default(1);
            $table->integer("sort_order")->default(999);
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
        Schema::dropIfExists('app_home_sections');
    }
}
