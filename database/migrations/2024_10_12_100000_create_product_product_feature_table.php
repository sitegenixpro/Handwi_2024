<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductProductFeatureTable extends Migration
{
    public function up()
    {
        Schema::create('product_product_feature', function (Blueprint $table) {
            $table->id();
            $table->integer("product_id")->nullable();
            $table->integer("product_feature_id")->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_product_feature');
    }
}
