<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingColumnsToStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            if (!Schema::hasColumn('stores', 'dial_code')) {
                $table->string('dial_code', 5)->nullable()->after('business_email');
            }

            if (!Schema::hasColumn('stores', 'mobile')) {
                $table->string('mobile', 20)->nullable()->after('dial_code');
            }

            if (!Schema::hasColumn('stores', 'description')) {
                $table->text('description')->nullable()->after('mobile');
            }

            if (!Schema::hasColumn('stores', 'latitude')) {
                $table->string('latitude', 50)->nullable()->after('location');
            }

            if (!Schema::hasColumn('stores', 'longitude')) {
                $table->string('longitude', 50)->nullable()->after('latitude');
            }

            if (!Schema::hasColumn('stores', 'address_line1')) {
                $table->string('address_line1', 900)->nullable()->after('longitude');
            }

            if (!Schema::hasColumn('stores', 'address_line2')) {
                $table->string('address_line2', 255)->nullable()->after('address_line1');
            }

            if (!Schema::hasColumn('stores', 'cover_image')) {
                $table->string('cover_image', 900)->nullable()->after('logo');
            }

            if (!Schema::hasColumn('stores', 'license_number')) {
                $table->string('license_number', 100)->nullable()->after('cover_image');
            }

            if (!Schema::hasColumn('stores', 'license_doc')) {
                $table->string('license_doc', 900)->nullable()->after('license_number');
            }

            if (!Schema::hasColumn('stores', 'vat_cert_number')) {
                $table->string('vat_cert_number', 100)->nullable()->after('license_doc');
            }

            if (!Schema::hasColumn('stores', 'vat_cert_doc')) {
                $table->string('vat_cert_doc', 900)->nullable()->after('vat_cert_number');
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
        Schema::table('stores', function (Blueprint $table) {
            if (Schema::hasColumn('stores', 'dial_code')) {
                $table->dropColumn('dial_code');
            }

            if (Schema::hasColumn('stores', 'mobile')) {
                $table->dropColumn('mobile');
            }

            if (Schema::hasColumn('stores', 'description')) {
                $table->dropColumn('description');
            }

            if (Schema::hasColumn('stores', 'latitude')) {
                $table->dropColumn('latitude');
            }

            if (Schema::hasColumn('stores', 'longitude')) {
                $table->dropColumn('longitude');
            }

            if (Schema::hasColumn('stores', 'address_line1')) {
                $table->dropColumn('address_line1');
            }

            if (Schema::hasColumn('stores', 'address_line2')) {
                $table->dropColumn('address_line2');
            }

            if (Schema::hasColumn('stores', 'cover_image')) {
                $table->dropColumn('cover_image');
            }

            if (Schema::hasColumn('stores', 'license_number')) {
                $table->dropColumn('license_number');
            }

            if (Schema::hasColumn('stores', 'license_doc')) {
                $table->dropColumn('license_doc');
            }

            if (Schema::hasColumn('stores', 'vat_cert_number')) {
                $table->dropColumn('vat_cert_number');
            }

            if (Schema::hasColumn('stores', 'vat_cert_doc')) {
                $table->dropColumn('vat_cert_doc');
            }
        });
    }
}
