@extends('layouts.app', ['title' => __('Новости')])

@section('content')

    <section class="container my-6 lg:my-12">
        <x-h1>{{ __('Новости') }}</x-h1>

        <div class="flex flex-wrap -m-4">
            @each('partials.client.news.article', $articles, 'article')
        </div>

        {{ $articles->appends(request()->except('page'))->links() }}
    </section>

    @includeWhen($products->count(), 'partials.client.shop.section')

@endsection
