@extends('layouts.app', ['title' => $seller->name])

@section('content')
    <section class="container py-12">
        <h1 class="text-3xl pl-12 lg:hidden font-bold font-slab mb-6 relative leading-tight">
            {{ $seller->name }} {{$seller->surname}}

            @auth
                <favourites
                    {{ $seller->in_favorites ? 'checked' : '' }}
                    class="absolute left-0 top-0 mt-1 hover:text-orange-600 transition duration-300"
                    type="{{ \App\Models\User::class }}"
                    model="{{ $seller->id }}"
                ></favourites>
            @endauth
        </h1>

        <div class="flex flex-wrap -mx-6">
            <div class="px-6 w-full sm:w-1/3">
                <img src="{{ $seller->avatar  }}"
                     class="bg-center bg-cover rounded" alt="">
                {{--<carousel :slides="{{ json_encode($seller->truck) }}"></carousel>--}}
            </div>

            <div class="px-6 w-full sm:w-2/3">
                <h1 class="text-4xl hidden lg:block font-bold font-slab mb-6 relative leading-tight">
                    {{ $seller->name }} {{$seller->surname}}

                    @auth
                        <favourites
                            {{ $seller->in_favorites ? 'checked' : '' }}
                            class="absolute left-0 top-0 -ml-10 mt-2 hover:text-orange-600 transition duration-300"
                            type="{{ \App\Models\User::class }}"
                            model="{{ $seller->id }}"
                        ></favourites>
                    @endauth
                </h1>

                <div class="flex flex-wrap -mx-3">
                    <div class="px-3 w-full flex-1">
                        <div class="content">
                            {!! $seller->email !!}
                        </div>
                        <div class="my-4">
                            <p class="text-lg mt-2 flex items-center">
                                <svg class="w-4 h-4 fill-current mr-2">
                                    <use xlink:href="{{ asset('images/icons/client.svg#call') }}"></use>
                                </svg>
                                <a href="tel:{{ $seller->phone }}"
                                   class="border-b border-dashed border-gray-400 hover:border-gray-600">
                                    +{{ $seller->phone }}
                                </a>
                            </p>
                            <p class="mt-2 flex items-center">
                                <svg class="w-4 h-4 fill-current mr-2">
                                    <use xlink:href="{{ asset('images/icons/client.svg#email') }}"></use>
                                </svg>
                                <a href="mailto:{{ $seller->email }}"
                                   class="border-b border-dashed border-gray-400 hover:border-gray-600">
                                    {{ $seller->email }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('partials.client.layout.social')
        <div class="flex flex-wrap -m-2 lg:-m-4">
            @foreach($seller->products as $product)
                <a href="{{ route('client.products.show', $product->getPath()) }}"
                   class="p-2 lg:p-4 w-full sm:w-1/2 lg:{{ $lgSize ?? 'w-1/4' }}">
                    <div class="rounded bg-center bg-cover pt-screen lg:pt-squire shadow-lg"
                         style="background-image: url('{{ $product->cover }}');"></div>
                    <div class="bg-white py-2 px-3 lg:py-3 lg:px-4 rounded mx-1 lg:mx-3 -mt-6 border-2 shadow-xl">
                        <h3 class="text-lg lg:text-xl font-bold font-slab leading-tight mb-2">{{ $product->title }}</h3>

                        @foreach($product->values as $value)
                            <p class="text-sm">
                                <strong>{{ number_format($value->price, 2, ',', ' ') }} грн</strong>
                                {{ __('от') }}
                                {{ number_format($value->min, 0, ',', ' ') }}
                                {{ $value->unit->name }}
                            </p>
                        @endforeach

                        <p class="text-sm font-bold font-slab mt-3">
                            {{ $product->user->name }}
                        </p>

                        @if($product->has_pickup && $product->city_id && !$product->has_delivery)
                            <p class="text-sm">
                                {!! __('shop.pickup_from', ['city' => $product->city->name]) !!}
                            </p>
                            <p class="text-sm">
                                {{$product->city->region->name}}
                            </p>
                        @elseif ($product->has_delivery && $product->city_id)
                            <p class="text-sm">
                                {!! __('shop.delivery_from', ['city' => $product->city->name]) !!}
                            </p>
                            <p class="text-sm">
                                {{$product->city->region->name}}
                            </p>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>

    </section>

    {{--@includeWhen($articles->count(), 'partials.client.news.feed')--}}

@endsection
