@extends('layouts.app', ['title' => __('nav.profile.history')])

@section('content')

    <section class="my-6 lg:my-12 container">
        @includeIf('client.profile.partials.nav')

        <div class="max-w-4xl mx-auto">
            @forelse($orders as $order)
                <h2 class="text-xl font-bold font-slab mb-6 text-center">
                    <span class="px-2 rounded bg-orange-600 text-white">№{{ $order->id }}</span>
                    <small>{{ __('от') }}</small>
                    {{ $order->created_at->format('d.m.Y H:i') }}
                </h2>

                <div class="border-2 rounded shadow-xl mb-12">
                    <table class="w-full">
                        {{--@foreach($order->carts as $item)
                            <tr class="{{ !$loop->first ? ' border-t-2' : '' }}">
                                <td class="p-3 text-gray-500 font-bold">{{ $loop->iteration }}</td>
                                <td class="p-3">
                                    <h3 class="font-bold font-slab text-lg">{{ $item->product->title }}</h3>

                                    <p class="text-sm font-bold font-slab mt-2">
                                        {{ $item->product->user->name }}
                                    </p>
                                    <p class="text-sm text-gray-600">
                                    {{ $item->product->user->phone }}
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        {!! __('shop.city', ['city' => $item->product->user->city->name]) !!}
                                        {{ $item->product->address ?? '' }}
                                    </p>
                                </td>
                                <td class="p-3 font-bold">
                                    {{ $item->quantity }}
                                    {{ $item->value->unit->name }} *
                                    {{ $item->value->price }} грн
                                </td>
                                <td class="p-3 font-bold font-slab text-xl">
                                    {{ $order->total }} грн
                                </td>
                            </tr>
                        @endforeach--}}
                        @foreach($order->details as $item)
                            <tr class="{{ !$loop->first ? ' border-t-2' : '' }}">
                                <td class="p-3 text-gray-500 font-bold">{{ $loop->iteration }}</td>
                                <td class="p-3">
                                    <h3 class="font-bold font-slab text-lg">{{ $item->product }}</h3>

                                    <p class="text-sm font-bold font-slab mt-2">
                                        {{ $item->seller->name }}
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        {{ $item->seller->phone ?? '' }}
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        {{$item->seller->region ?? ''}}
                                        {!! __('shop.city', ['city' => $item->seller->city]) !!}
                                        {{ $item->address ?? '' }}
                                    </p>
                                </td>
                                <td class="p-3 font-bold">
                                    {{ $item->quantity }}
                                    {{ $item->unit }} *
                                    {{ $item->price }} грн
                                </td>
                                <td class="p-3 font-bold font-slab text-xl">
                                    {{ $item->total }} грн
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @empty
                <h2 class="text-xl font-bold font-slab mb-6 text-center">
                    {{ __('shop.orders.empty') }}
                </h2>
            @endforelse
        </div>
    </section>

@endsection
