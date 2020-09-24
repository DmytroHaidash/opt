@extends('layouts.app', ['title' => __('Перевозчики')])

@section('content')
    <section class="my-6 lg:my-12">
        <div class="container">
            <div class="flex flex-wrap -mx-3 lg:-mx-6">
                <div class="px-3 lg:px-6 w-full sm:w-1/3 lg:w-1/4">
                    @includeIf('partials.client.carriers.filters')
                </div>

                <div class="px-3 lg:px-6 w-full sm:w-2/3 lg:w-3/4">
                    <h1 hidden>{{ __('Перевозчики') }}</h1>
                    @includeIf('partials.client.carriers.carrier', ['lgSize' => 'w-1/3'])
                </div>
            </div>
        </div>
    </section>

    @includeWhen($articles->count(), 'partials.client.news.feed')

@endsection
