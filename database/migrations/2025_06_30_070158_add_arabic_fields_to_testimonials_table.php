<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArabicFieldsToTestimonialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tesimonial', function (Blueprint $table) {
            $table->string('name_ar')->nullable()->after('name');
            $table->string('designation_ar')->nullable()->after('designation');
            $table->text('comment_ar')->nullable()->after('comment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tesimonial', function (Blueprint $table) {
            $table->dropColumn(['name_ar', 'designation_ar', 'comment_ar']);
        });
    }
}
