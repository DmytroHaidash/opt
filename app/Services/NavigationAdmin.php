<?php


namespace App\Services;


use App\Models\Ticket;
use Auth;

class NavigationAdmin
{
    public function routes()
    {
        $admin = [];
        $booker = [];
        $moderator = [];
        $writer = [];

        $items = [
            (object)[
                'name' => __('admin.board.title'),
                'route' => route('admin.board'),
                'match' => app('router')->is('admin.board'),
                'icon' => 'graph',
            ],
        ];

        if (Auth::user()->hasRole('moderator') || Auth::user()->hasRole('admin')) {
            $moderator = [
                (object)[
                    'name' => __('admin.shop.title'),
                    'route' => route('admin.products.index'),
                    'match' => app('router')->is(['admin.products.*', 'admin.units.*']) || request('taxonomy') === 'shop',
                    'icon' => 'data',
                    'children' => [
                        (object)[
                            'name' => __('admin.products.all'),
                            'route' => route('admin.products.index'),
                            'match' => app('router')->is('admin.products.index')
                        ],
                        (object)[
                            'name' => __('admin.products.create'),
                            'route' => route('admin.products.create'),
                            'match' => app('router')->is('admin.products.create')
                        ],
                        (object)[
                            'name' => __('admin.categories.title'),
                            'route' => route('admin.categories.index', ['taxonomy' => 'shop']),
                            'match' => app('router')->is('admin.categories.*') && request('taxonomy') === 'shop'
                        ],
                        (object)[
                            'name' => __('admin.units.title'),
                            'route' => route('admin.units.index'),
                            'match' => app('router')->is('admin.units.*')
                        ]
                    ]
                ],
                (object)[
                    'name' => __('admin.tickets.title'),
                    'route' => route('admin.tickets.index'),
                    'match' => app('router')->is('admin.tickets.*'),
                    'unread' => Ticket::where('is_resolved', 0)->count(),
                    'icon' => 'chat',
                ],
            ];
        }

        if (Auth::user()->hasRole('writer') || Auth::user()->hasRole('admin')) {
            $writer = [
                (object)[
                    'name' => __('admin.news.title'),
                    'route' => route('admin.articles.index'),
                    'match' => app('router')->is('admin.articles.*') || request('taxonomy') === 'news',
                    'icon' => 'newspaper',
//                'children' => [
//                    (object)[
//                        'name' => __('admin.news.all'),
//                        'route' => route('admin.articles.index'),
//                        'match' => app('router')->is('admin.articles.index')
//                    ],
//                    (object)[
//                        'name' => __('admin.articles.create'),
//                        'route' => route('admin.articles.create'),
//                        'match' => app('router')->is('admin.articles.create')
//                    ]
//                ]
                ],
                (object)[
                    'name' => __('admin.pages.title'),
                    'route' => route('admin.pages.index'),
                    'match' => app('router')->is('admin.pages.*'),
                    'icon' => 'webpage'
                ],
            ];
        }

        if (Auth::user()->hasRole('booker') || Auth::user()->hasRole('admin')) {
            $booker = [
                (object)[
                    'name' => __('admin.orders.title'),
                    'route' => route('admin.orders.index'),
                    'match' => app('router')->is('admin.orders.*'),
                    'icon' => 'wallet'
                ],
            ];
        }

        if (Auth::user()->hasRole('admin')) {
            $admin = [
                (object)[
                    'name' => __('admin.users.title'),
                    'route' => route('admin.users.index'),
                    'match' => app('router')->is('admin.users.*'),
                    'icon' => 'users'
                ],
                (object)[
                    'name' => __('admin.settings.title'),
                    'route' => route('admin.settings.index'),
                    'match' => app('router')->is('admin.settings.*'),
                    'icon' => 'settings'
                ],
            ];
        }

        return array_merge($items, $booker, $admin, $moderator, $writer);
    }
}
