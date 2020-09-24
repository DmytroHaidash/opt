@extends('layouts.app', ['title' => __('Корзина')])

@section('content')

    <section class="container my-6 lg:my-12">
        <div class="max-w-2xl mx-auto border-2 rounded shadow-xl mb-12">
            <table class="w-full">
                <thead>
                <tr class="text-gray-500 text-left text-xs">
                    <th class="p-3" colspan="2">{{ __('Название') }}</th>
                    <th class="p-3">{{ __('Цена') }}</th>
                    <th class="p-3"></th>
                    <th class="p-3"></th>
                </tr>
                </thead>

                <tbody is="cart-contents"></tbody>
            </table>
        </div>
    </section>

@endsection
