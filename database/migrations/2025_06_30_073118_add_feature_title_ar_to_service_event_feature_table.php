<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFeatureTitleArToServiceEventFeatureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('service_event_feature', 'feature_title_ar')) {
            Schema::table('service_event_feature', function (Blueprint $table) {
                $table->string('feature_title_ar')->nullable()->after('feature_title');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('service_event_feature', 'feature_title_ar')) {
            Schema::table('service_event_feature', function (Blueprint $table) {
                $table->dropColumn('feature_title_ar');
            });
        }
    }
}
