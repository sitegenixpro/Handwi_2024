<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArabicFieldsToEventFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_features', function (Blueprint $table) {
            if (!Schema::hasColumn('event_features', 'name_ar')) {
                $table->string('name_ar')->nullable()->after('name');
            }
            if (!Schema::hasColumn('event_features', 'description_ar')) {
                $table->text('description_ar')->nullable()->after('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('event_features', function (Blueprint $table) {
            if (Schema::hasColumn('event_features', 'name_ar')) {
                $table->dropColumn('name_ar');
            }
            if (Schema::hasColumn('event_features', 'description_ar')) {
                $table->dropColumn('description_ar');
            }
        });
    }
}
