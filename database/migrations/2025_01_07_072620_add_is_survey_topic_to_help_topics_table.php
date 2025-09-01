<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsSurveyTopicToHelpTopicsTable extends Migration
{
    public function up()
    {
        Schema::table('help_topics', function (Blueprint $table) {
            $table->boolean('is_survey_topic')->default(false)->after('topic');
        });
    }

    public function down()
    {
        Schema::table('help_topics', function (Blueprint $table) {
            $table->dropColumn('is_survey_topic');
        });
    }
}
