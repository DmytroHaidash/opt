<?php

use Illuminate\Database\Seeder;

class RegionsTableSeeder extends Seeder
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

        $regions = explode("\n", file_get_contents(
            database_path('datasets/_regions.csv')
        ));

        $regions = collect($regions)->skip(1)->map(function($region) {
            return str_getcsv($region);
        })->filter(function($region) {
            return isset($region[1]) && $region[1] == '2';
        })->except(3206)->map(function($region) {
            return [
                'name' => json_encode([
                    'uk' => $region[3], 'ru' => $region[2]
                ], JSON_UNESCAPED_UNICODE),
                'token' => $region[0],
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ];
        })->sort()->values();

        $tokens = $regions->pluck('token')->all();

        $file = new SplFileObject(
            database_path('datasets/_cities.csv')
        );
        $file->setFlags(\SplFileObject::READ_CSV);
        $file->seek(1);

        $cities = collect([]);

        while(!$file->eof()) {
            $city = $file->current();

            if (isset($city[3]) && in_array($city[3], $tokens)) $cities->push([
                'name' => json_encode([
                    'ru' => $city[4], 'uk' => $city[7]
                ], JSON_UNESCAPED_UNICODE),
                'region_id' => $regions->search($regions->firstWhere('token', $city[3])) + 1,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ]);

            $file->next();
        }

        \App\Models\Region::insert($regions->map(function($region) {
            unset($region['token']);

            return $region;
        })->all());

        $cities->chunk(1000)->each(function($chunk) {
            \App\Models\City::insert($chunk->all());
        });
    }
}
