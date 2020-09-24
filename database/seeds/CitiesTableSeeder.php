<?php

use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [
            ['ru' => 'Запорожье', 'uk' => 'Запоріжжя'],
            ['ru' => 'Днепр', 'uk' => 'Дніпро'],
            ['ru' => 'Киев', 'uk' => 'Київ'],
            ['ru' => 'Харьков', 'uk' => 'Харків'],
        ];

        foreach ($cities as $city) {
            \App\Models\City::create([
                'name' => $city
            ]);
        }
    }
}
