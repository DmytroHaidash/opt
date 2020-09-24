<?php

use Illuminate\Database\Seeder;

class RegionsAndCitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        \App\Models\Region::truncate();
        \App\Models\City::truncate();
        Schema::enableForeignKeyConstraints();

        DB::unprepared(file_get_contents(database_path('datasets/regions_cities.sql')));
    }
}
