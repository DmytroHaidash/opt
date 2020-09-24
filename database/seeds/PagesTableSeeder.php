<?php

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = [
            'home' => [
                'ru' => 'Главная',
                'uk' => 'Головна'
            ],
            'about' => [
                'ru' => 'О нас',
                'uk' => 'Про нас'
            ],
            'contact-us' => [
                'ru' => 'Контакты',
                'uk' => 'Контакти',
            ],
            'terms-of-use' => [
                'ru' => 'Пользовательское соглашение',
                'uk' => 'Угода користувача'
            ],
            'privacy-policy' => [
                'ru' => 'Политика конфиденфиальности',
                'uk' => 'Політика конфіденфіальності'
            ]
        ];

        foreach ($pages as $slug => $title) {
            \App\Models\Page::create([
                'slug' => $slug,
                'title' => $title
            ]);
        }
    }
}
