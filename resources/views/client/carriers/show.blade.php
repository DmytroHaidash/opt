@extends('layouts.app', ['title' => $carrier->name])

@section('content')
    <section class="container py-12">
        <h1 class="text-3xl pl-12 lg:hidden font-bold font-slab mb-6 relative leading-tight">
            {{ $carrier->name }} {{$carrier->surname}}

            @auth
                <favourites
                    {{ $carrier->in_favorites ? 'checked' : '' }}
                    class="absolute left-0 top-0 mt-1 hover:text-orange-600 transition duration-300"
                    type="{{ \App\Models\User::class }}"
                    model="{{ $carrier->id }}"
                ></favourites>
            @endauth
        </h1>

        <div class="flex flex-wrap -mx-6">
            <div class="px-6 w-full sm:w-1/3">
                <carousel :slides="{{ json_encode($carrier->truck) }}"></carousel>
            </div>

            <div class="px-6 w-full sm:w-2/3">
                <h1 class="text-4xl hidden lg:block font-bold font-slab mb-6 relative leading-tight">
                    {{ $carrier->name }}

                    @auth
                        <favourites
                            {{ $carrier->in_favorites ? 'checked' : '' }}
                            class="absolute left-0 top-0 -ml-10 mt-2 hover:text-orange-600 transition duration-300"
                            type="{{ \App\Models\User::class }}"
                            model="{{ $carrier->id }}"
                        ></favourites>
                    @endauth
                </h1>

                <div class="flex flex-wrap -mx-3">
                    <div class="px-3 w-full flex-1">
                        <div class="content">
                            {!! $carrier->carrier_description !!}
                        </div>
                        <div class="my-4">
                            @if($carrier->type_car)
                                <p class="mt-4">
                                    {{ __('auth.type_car') }}
                                    <span class="font-semibold">{{ $carrier->type_car }}</span>
                                </p>
                            @endif
                            @if($carrier->type_car)
                                <p class="mt-4">
                                    {{ __('auth.brand_car') }}
                                    <span class="font-semibold">{{ $carrier->brand_car }}</span>
                                </p>
                            @endif
                            @if($carrier->price_km)
                                <p class="mt-4">
                                    {{ __('auth.price_km') }}
                                    <span class="font-semibold">{{ $carrier->price_km }}грн</span>
                                </p>
                            @endif
                            @if($carrier->tonnage)
                                <p class="mt-4">
                                    {{ __('auth.tonnage') }}
                                    <span class="font-semibold">{{ $carrier->tonnage }}</span>
                                </p>
                            @endif
                            @if($carrier->car_region)
                                <p class="mt-4">
                                    {{ __('auth.car_region') }}
                                    <span class="font-semibold">{{ $carrier->region_car->name }}</span>
                                </p>
                            @endif
                            @if($carrier->all_region)
                                <p class="mt-4">
                                    <span class="font-semibold">{{ __('auth.all_region') }}</span>
                                </p>
                            @elseif($carrier->carrier_regions->count())
                                <p class="mt-4">
                                    {{ __('carrier.work_at_region') }}
                                    @foreach($carrier->carrier_regions as $region)
                                        <span class="font-semibold">{{$region->name}}{{$loop->last ? '.' : ','}}</span>
                                    @endforeach
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="px-3 w-full lg:w-64">
                        @include('partials.client.carriers.seller')
                    </div>
                </div>
            </div>
        </div>
        @include('partials.client.layout.social')
    </section>

    @includeWhen($articles->count(), 'partials.client.news.feed')

@endsection
@section('meta')
    <meta property="og:title" content="{{ $carrier->name }}">
    @if($carrier->hasMedia('carrier'))
        <meta property="og:image" content="{{ $carrier->getFirstMediaUrl('carrier') }}"/>
    @else
        <meta property="og:image" content="{{ asset('images/icons/apple-touch-icon.png') }}"/>
    @endif
@endsection
