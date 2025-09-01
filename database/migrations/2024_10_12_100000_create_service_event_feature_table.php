<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceEventFeatureTable extends Migration
{
    public function up()
    {
        Schema::create('service_event_feature', function (Blueprint $table) {
            $table->id();
            $table->integer("service_id")->nullable();
            $table->integer("event_feature_id")->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_event_feature');
    }
}
