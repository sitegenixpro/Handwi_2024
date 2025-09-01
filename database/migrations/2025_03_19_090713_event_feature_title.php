<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EventFeatureTitle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_event_feature', function (Blueprint $table) {
            $table->string('feature_title',600)->nullable();
           // $table->string('doc',600)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_event_feature', function (Blueprint $table) {
            $table->dropColumn('feature_title');
           // $table->dropColumn('doc');
        });
    }
}
