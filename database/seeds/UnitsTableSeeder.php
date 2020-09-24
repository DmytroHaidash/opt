<?php

use Illuminate\Database\Seeder;

class UnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $units = [
            [
                'name' => ['ru' => 'гр', 'uk' => 'гр'],
                'nicename' => ['ru' => 'Грамм', 'uk' => 'Грам']
            ],
            [
                'name' => ['ru' => 'кг', 'uk' => 'кг'],
                'nicename' => ['ru' => 'Килограмм', 'uk' => 'Кілограм']
            ],
            [
                'name' => ['ru' => 'ц', 'uk' => 'ц'],
                'nicename' => ['ru' => 'Центнер', 'uk' => 'Центнер']
            ],
            [
                'name' => ['ru' => 'т', 'uk' => 'т'],
                'nicename' => ['ru' => 'Тонна', 'uk' => 'Тонна']
            ],
            [
                'name' => ['ru' => 'шт', 'uk' => 'шт'],
                'nicename' => ['ru' => 'Штука', 'uk' => 'Штука']
            ],
            [
                'name' => ['ru' => 'мм', 'uk' => 'мм'],
                'nicename' => ['ru' => 'Миллиметр', 'uk' => 'Міліметр']
            ],
            [
                'name' => ['ru' => 'см', 'uk' => 'см'],
                'nicename' => ['ru' => 'Сантиметр', 'uk' => 'Сантиметр']
            ],
        ];

        foreach ($units as $unit) {
            \App\Models\Unit::create($unit);
        }
    }
}
