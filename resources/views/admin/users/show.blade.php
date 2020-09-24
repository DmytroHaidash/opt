@extends('layouts.admin', ['title' => $user->name])

@section('content')

    <section>
        <div class="flex items-center">
            <h1 class="text-3xl font-bold font-slab">
                {{ $user->name }} {{ $user->surname }}
            </h1>

            <div
                class="border-2 border-gray-600 px-2 font-semibold rounded ml-3">{{ __('auth.roles.' . $user->role) }}</div>
        </div>

        <div class="text-2xl">
            <p>
                <a href="mailto:{{ $user->email }}" class="border-b hover:text-orange-600 hover:border-orange-300">
                    {{ $user->email }}
                </a>
            </p>

            <p>
                <a href="tel:{{ $user->phone }}" class="border-b hover:text-orange-600 hover:border-orange-300">
                    +{{ $user->phone }}
                </a>
            </p>
        </div>
        @if($user->organization)
            <p class="mt-4">
                {{ __('auth.organization') }}
                <span class="font-semibold">{{ $user->organization }}</span>
            </p>
        @endif
        @if($user->city_id)
            <p class="mt-4">
                {{ __('shop.region') }}
                <span class="font-semibold">{{ $user->city->region->name }}</span>
            </p>
            <p class="mt-4">
                {{ __('shop.settlement') }}
                <span class="font-semibold">{{ $user->city->name }}</span>
            </p>
        @endif
        @if($user->type_car)
            <p class="mt-4">
                {{ __('auth.type_car') }}
                <span class="font-semibold">{{ $user->type_car }}</span>
            </p>
        @endif
        @if($user->brand_car)
            <p class="mt-4">
                {{ __('auth.brand_car') }}
                <span class="font-semibold">{{ $user->brand_car }}</span>
            </p>
        @endif
        @if($user->tonnage)
            <p class="mt-4">
                {{ __('auth.tonnage') }}
                <span class="font-semibold">{{ $user->tonnage }}</span>
            </p>
        @endif
        @if($user->price_km)
            <p class="mt-4">
                {{ __('auth.price_km') }}
                <span class="font-semibold">{{ $user->price_km }}</span>
            </p>
        @endif
        @if($user->car_region)
            <p class="mt-4">
                {{ __('auth.car_region') }}
                <span class="font-semibold">{{ $user->region_car->name }}</span>
            </p>
        @endif
        @if($user->hasRole('carrier') )
            @if($user->all_region)
                <p class="mt-4">
                    <span class="font-semibold">{{ __('auth.all_region') }}</span>
                </p>
            @else
                <p class="mt-4">
                    {{ __('carrier.work_at_region') }}
                    @foreach($user->carrier_regions as $region)
                        <span class="font-semibold">{{$region->name}}{{$loop->last ? '.' : ','}}</span>
                        @endforeach
                </p>
            @endif
        @endif
        <p class="mt-4">
            {{ __('admin.users.fields.registered_at') }} &bull;
            <span class="font-semibold">{{ $user->created_at->format('d.m.Y H:i') }}</span>
        </p>

    </section>

@endsection
