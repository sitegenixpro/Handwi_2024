<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSocialFieldsToContactUsSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contact_us_settings', function (Blueprint $table) {
            $table->string('pinterest')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('whatsapp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contact_us_settings', function (Blueprint $table) {
            $table->dropColumn(['pinterest', 'tiktok', 'whatsapp']);
        });
    }
}
