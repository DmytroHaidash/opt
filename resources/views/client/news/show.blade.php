@extends('layouts.app', ['title' => $article->title])

@section('content')

    <section class="container py-12">
        <div class="flex flex-wrap -mx-4">
            <div class="px-4 w-full lg:w-2/3">
                <h1 class="text-4xl leading-tight font-bold font-slab">{{ $article->title }}</h1>

                @if ($article->description)
                    <div class="bg-gray-50 py-4 px-6 my-6 text-lg rounded">
                        {{ $article->description }}
                    </div>
                @endif

                <div class="content">{!! $article->content !!}</div>
            </div>

            <div class="px-4 w-full lg:w-1/3">
                @includeWhen($articles->count(), 'partials.client.news.side-feed')
            </div>
        </div>
    </section>

    @includeIf('partials.client.shop.section', ['container' => 'bg-gray-50'])

@endsection
