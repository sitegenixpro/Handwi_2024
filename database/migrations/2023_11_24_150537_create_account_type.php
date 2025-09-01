<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\AccountType;
class CreateAccountType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_type', function (Blueprint $table) {
            $table->id();
            $table->string('name',600)->nullable();
            $table->string('description',600)->nullable();
             $table->integer('sort_order')->default(0);
             $table->boolean('status')->default(1);
             $table->string('indvidual_name')->nullable();
            $table->text('indvidual_image')->nullable();
            $table->integer('deleted')->default(0);
            $table->timestamps();
        
        });
        Schema::table('account_type', function (Blueprint $table) {
            AccountType::where('id',1)->update(['name' => 'Commercial Centers(SHOPS)']);
            AccountType::where('id',2)->update(['name' => 'Reservations']);
            AccountType::where('id',3)->update(['name' => 'Individuals']);
            AccountType::where('id',4)->update(['name' => 'Services Providers']);
            AccountType::where('id',5)->update(['name' => 'WholeSellers']);
            AccountType::where('id',6)->update(['name' => 'Delivery Representative']);
        });

        Schema::create('user_account_types', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('account_type_id');
            $table->integer('activity_type_id');
            $table->timestamps();
        });
        Schema::create('temp_user_account_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('temp_user_id');
            $table->integer('account_type_id');
            $table->integer('activity_type_id');
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
        Schema::dropIfExists('account_type');
        Schema::dropIfExists('user_account_types');
        Schema::dropIfExists('temp_user_account_types');
    }
}
