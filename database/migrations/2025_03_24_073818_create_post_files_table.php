<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_files', function (Blueprint $table) {
            $table->id();
            $table->integer('post_id');
            $table->string('height');
            $table->string('width');
            $table->string('extension');
            $table->integer('is_default')->default(0);
            $table->text('url');
            $table->string('duration')->default('');
            $table->text('thumb_image')->nullable();
            $table->integer('have_hls_url')->default(0);
            $table->text('hls_url')->nullable();
            $table->text('hls_cdn_url')->nullable();


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
        Schema::dropIfExists('post_files');
    }
}
