<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCarrierColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('type_car')->nullable()->after('role');
            $table->string('brand_car')->nullable()->after('role');
            $table->decimal('price_km', 12, 2)->nullable()->after('role');
            $table->decimal('tonnage', 5, 3)->nullable()->after('role');
            $table->unsignedBigInteger('car_region')->nullable()->after('tonnage');
            $table->boolean('all_region')->default(0)->after('tonnage');
            $table->json('worked_region')->nullable()->after('all_region');
            $table->boolean('published_carrier')->default(0)->after('worked_region');
            $table->json('carrier_description')->nullable()->after('published_carrier');

            $table->foreign('car_region')->references('id')->on('regions')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['car_region']);
            $table->dropColumn('type_car', 'brand_car', 'price_km', 'tonnage', 'car_region', 'all_region',
                'worked_region', 'published_carrier', 'carrier_description');
        });
    }
}
