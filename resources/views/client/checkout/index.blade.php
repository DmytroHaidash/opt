@extends('layouts.app', ['title' => __('shop.checkout.title')])

@section('content')

    <section class="container my-6 lg:my-12">
        <x-h1>{{ __('shop.checkout.title') }}</x-h1>

        <div class="max-w-4xl mx-auto border-2 rounded shadow-xl mb-12">
            <table class="w-full">
                @foreach($cartContents as $item)
                    @includeIf('client.checkout.partials.cart-item')
                @endforeach
            </table>
        </div>

        <form action="{{ route('client.checkout.store') }}" method="post" class="max-w-sm mx-auto">
            @csrf

            @guest
                @includeIf('client.checkout.partials.guest')
            @endguest

            <div class="mt-6 text-center">
                <button class="button button--primary" type="submit">
                    {{ __('shop.checkout.finish') }}
                </button>
            </div>
        </form>
    </section>

@endsection
