<?php


namespace App\Services;


use App\Models\Page;
use Auth;
use Cache;
use Illuminate\Support\Collection;

class NavigationClient
{
    public function __construct()
    {
        Cache::rememberForever('pages', function () {
            return Page::where('slug', '!=', 'home')->get();
        });
    }

    public function header(): Collection
    {
        return Cache::get('pages')->filter(function (Page $page) {
            return in_array($page->slug, ['about', 'contact-us']);
        })->map(function (Page $page) {
            return (object)[
                'name' => $page->title,
                'route' => url($page->slug),
                'match' => request()->is($page->slug)
            ];
        })->prepend((object)[
            'name' => __('Перевозчики'),
            'route' => route('client.carriers.index'),
            'match' => app('router')->is('client.carriers.*')
        ])->prepend((object)[
            'name' => __('Магазин'),
            'route' => route('client.products.index'),
            'match' => app('router')->is('client.products.*')
        ])->push((object) [
            'name' => __('Новости'),
            'route' => route('client.news.index'),
            'match' => app('router')->is('client.news.*')
        ]);
    }

    public function footer(): Collection
    {
        return Cache::get('pages')->map(function (Page $page) {
            return (object)[
                'name' => $page->title,
                'route' => url($page->slug),
                'match' => request()->is($page->slug)
            ];
        });
    }

    public function dropdown(): Collection
    {
        $output = collect([]);

        if (Auth::user()->hasRole('admin|moderator|writer|booker')) {
            $output->push((object)[
                'name' => __('nav.admin'),
                'route' => route('admin.board'),
                'match' => false
            ]);
        }

        $output->push((object)[
            'name' => __('Профиль'),
            'route' => route('client.profile.index'),
            'match' => app('router')->is('client.profile.index')
        ])->push((object)[
            'name' => __('nav.profile.history'),
            'route' => route('client.profile.history'),
            'match' => app('router')->is('client.profile.history')
        ]);

        if (Auth::user()->hasRole('admin|seller')) {
            $output->push((object)[
                'name' => __('nav.products'),
                'route' => route('client.profile.products.index'),
                'match' => app('router')->is('client.profile.products.*')
            ]);
        }

        $output->push((object)[
            'name' => __('nav.profile.favorites'),
            'route' => route('client.profile.favorites'),
            'match' => app('router')->is('client.profile.favorites')
        ]);

        return $output;
    }
}
