@extends('layouts.admin', ['title' => __('admin.orders.title')])

@section('content')

    <table class="w-full">
        <x-table-header />

        @forelse($orders as $order)
            <tr>
                <td class="p-3">{{ $order->id }}</td>
                <td class="p-3 w-full font-bold">{{ $order->buyer->name }}</td>
                <td class="p-3">{{ $order->carts_count }}</td>
                <td class="p-3 whitespace-no-wrap">{{ $order->total }} грн</td>
                <td class="p-3 whitespace-no-wrap">{{ $order->created_at->format('d.m.Y H:i') }}</td>
                <td class="p-3 w-8">
                    <x-table-actions :show="route('admin.orders.show', $order)"/>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="p-3 text-center">{{ __('admin.not_found') }}</td>
            </tr>
        @endforelse
    </table>

@endsection
