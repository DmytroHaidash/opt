@extends('layouts.app', ['title' => $product->title])

@section('content')
    <section class="container py-12">
        <h1 class="text-3xl pl-12 lg:hidden font-bold font-slab mb-6 relative leading-tight">
            {{ $product->title }}

            @auth
                <favourites
                    {{ $product->in_favorites ? 'checked' : '' }}
                    class="absolute left-0 top-0 mt-1 hover:text-orange-600 transition duration-300"
                    type="{{ \App\Models\Product::class }}"
                    model="{{ $product->id }}"
                ></favourites>
            @endauth
        </h1>

        <div class="flex flex-wrap -mx-6">
            <div class="px-6 w-full sm:w-1/3">
                <carousel :slides="{{ json_encode($product->gallery) }}"></carousel>
            </div>

            <div class="px-6 w-full sm:w-2/3">
                <h1 class="text-4xl hidden lg:block font-bold font-slab mb-6 relative leading-tight">
                    {{ $product->title }}

                    @auth
                        <favourites
                            {{ $product->in_favorites ? 'checked' : '' }}
                            class="absolute left-0 top-0 -ml-10 mt-2 hover:text-orange-600 transition duration-300"
                            type="{{ \App\Models\Product::class }}"
                            model="{{ $product->id }}"
                        ></favourites>
                    @endauth
                </h1>

                <div class="flex flex-wrap -mx-3">
                    <div class="px-3 w-full flex-1">
                        <div class="content">
                            {!! $product->content !!}
                        </div>
                        <div class="my-4">
                            @if($product->price_arranged)
                                <strong>
                                    {{__('admin.products.fields.price_arranged')}}
                                </strong>
                            @endif
                            @foreach($product->values as $value)
                                @if(!Auth::user() || Auth::user()->id != $product->user_id)

                                    <quantity

                                        :step="{{ $value->step }}"
                                        :min="{{ $value->min }}"
                                        :max="{{ $value->max ?? 10 ** 100 }}"
                                        :value="{{ $value->id }}"
                                        unit="{{ $value->unit->name }}"
                                        route="{{ route('client.cart.add', $product) }}"
                                    >
                                        <strong>{{ number_format($value->price, 2, ',', ' ') }} грн</strong>
                                        {{ __('от') }}
                                        {{ number_format($value->min, 0, ',', ' ') }}
                                        {{ $value->unit->name }}

                                    </quantity>

                                @else
                                    <strong>{{ number_format($value->price, 2, ',', ' ') }} грн</strong>
                                    {{ __('от') }}
                                    {{ number_format($value->min, 0, ',', ' ') }}
                                    {{ $value->unit->name }}
                                @endif
                            @endforeach
                        </div>
                        @includeWhen($product->has_pickup && $product->latitude && $product->longitude, 'partials.client.shop.map')
                    </div>

                    <div class="px-3 w-full lg:w-64">
                        @include('partials.client.shop.seller')
                    </div>
                </div>
            </div>
        </div>
        @include('partials.client.layout.social')
    </section>

    @includeWhen($articles->count(), 'partials.client.news.feed')

@endsection

@section('meta')
    <meta property="og:title" content="{{ $product->title }}">
    @if($product->hasMedia())
        <meta property="og:image" content="{{ $product->getFirstMediaUrl() }}"/>
    @else
        <meta property="og:image" content="{{ asset('images/icons/apple-touch-icon.png') }}" />
    @endif
@endsection
