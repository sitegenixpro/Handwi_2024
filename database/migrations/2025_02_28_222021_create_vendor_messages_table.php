<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('vendor_messages', function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable()->nullable();
            $table->text('email')->nullable()->nullable(); 
            $table->text('phone')->nullable()->nullable(); 
            $table->text('subject')->nullable()->nullable();  
            $table->text('message')->nullable()->nullable();         // ID of the user who reports
            $table->bigInteger('vendor_id');       // ID of the artist being reported
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vendor_messages');
    }
};
