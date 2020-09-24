@extends('layouts.admin', ['title' => __('admin.orders.title')])

@section('content')

    <section>
        <p class="font-bold text-gray-600">{{ __('admin.orders.fields.buyer') }}:</p>
        <h1 class="font-bold font-slab text-2xl">{{ $order->buyer->name }}</h1>

        @isset($order->buyer->id)
            <p class="text-lg">
                <a
                    href="tel:{{ $order->buyer->phone }}"
                    class="border-b border-dashed"
                >+{{ $order->buyer->phone }}</a>
            </p>
            <p class="text-lg">
                <a
                    href="mailto:{{ $order->buyer->email }}"
                    class="border-b border-dashed"
                >{{ $order->buyer->email }}</a>
            </p>
        @endisset

        <div class="max-w-4xl border-2 rounded shadow-xl mt-6">
            <table class="w-full">
                @foreach($order->details as $item)
                    <tr class="{{ !$loop->first ? ' border-t-2' : '' }}">
                        <td class="p-3 text-gray-500 font-bold">{{ $loop->iteration }}</td>
                        <td class="p-3">
                            <h3 class="font-bold font-slab text-lg leading-none">{{ $item->product }}</h3>

                            <p class="text-sm font-bold font-slab mt-2">
                                {{ $item->seller->name }}, {{ __('shop.city', ['city' => $item->seller->city]) }}
                            </p>
                        </td>
                        <td class="p-3 font-bold">
                            {{ $item->quantity }}
                            {{ $item->unit }} *
                            {{ $item->price }} грн
                        </td>
                        <td class="p-3 font-bold font-slab text-xl">
                            {{ $item->price * $item->quantity }} грн
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </section>

@endsection
