<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['ru' => 'Овощи', 'uk' => 'Овочі'],
            ['ru' => 'Фрукты', 'uk' => 'Фрукти'],
            ['ru' => 'Зелень', 'uk' => 'Зелень'],
            ['ru' => 'Салаты', 'uk' => 'Салати'],
        ];

        foreach ($categories as $category) {
            Category::create([
                'title' => $category,
                'taxonomy' => 'shop'
            ]);
        }
    }
}
