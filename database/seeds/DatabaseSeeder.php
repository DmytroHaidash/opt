<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RegionsAndCitiesTableSeeder::class,
            UsersTableSeeder::class,
            UnitsTableSeeder::class,
            PagesTableSeeder::class,
            CategoriesTableSeeder::class,
            SettingsTableSeeder::class
        ]);
    }
}
