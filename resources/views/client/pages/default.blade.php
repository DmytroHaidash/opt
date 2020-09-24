@extends('layouts.app', ['title' => $page->title])

@section('content')

    <section class="container py-12">
        <div class="flex flex-wrap -mx-4">
            <div class="px-4 w-full lg:w-2/3">
                <h1 class="text-4xl leading-tight font-bold font-slab mb-6">
                    {{ $page->title }}
                </h1>

                <div class="content">{!! $page->content !!}</div>

                @includeWhen($page->slug === 'contact-us', 'partials.client.layout.tickets')
            </div>

            <div class="px-4 w-full lg:w-1/3">
                @includeWhen($articles->count(), 'partials.client.news.side-feed')
            </div>
        </div>
    </section>

    @includeIf('partials.client.shop.section', ['container' => 'bg-gray-50'])

@endsection
