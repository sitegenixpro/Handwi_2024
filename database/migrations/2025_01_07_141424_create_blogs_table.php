<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('name'); // Blog name
            $table->text('description')->nullable(); // Blog description
            $table->string('blog_image')->nullable(); // Blog image filename
            $table->boolean('active')->default(0); // Active status
            $table->integer('deleted')->default(0);
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}
