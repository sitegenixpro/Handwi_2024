<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandingPageSettingsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('landing_page_settings')) {
            Schema::create('landing_page_settings', function (Blueprint $table) {
                $table->id();
                $table->string('meta_key');
                $table->text('meta_value')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('landing_page_settings');
    }
}


