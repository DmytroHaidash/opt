@extends('layouts.app', ['title' => __('shop.checkout.success', ['order' => $order->id])])

@section('content')

    <section class="container my-6 lg:my-12">
        <div class="mb-6 w-48 h-48 mx-auto" data-animation></div>

        <h1 class="text-3xl font-slab font-bold text-center mb-6">
            <div>{{ __('shop.checkout.success', ['order' => $order->id]) }}</div>
            <div class="border-b-2 mt-2 border-orange-600 w-16 mx-auto"></div>
        </h1>

        <div class="max-w-4xl mx-auto border-2 rounded shadow-xl mb-12">
            <table class="w-full">
                @foreach($order->carts as $item)
                    @includeIf('client.checkout.partials.cart-item')
                @endforeach
            </table>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('client.products.index') }}" class="button button--primary">
                {{ __('shop.back_to_shop') }}
            </a>
        </div>
    </section>

@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.6.7/lottie.min.js"></script>
    <script>
        var container = document.querySelector('[data-animation]');

        var animation = bodymovin.loadAnimation({
            container: container,
            path: '{{ asset("lottie/success-animation.json") }}',
            renderer: 'svg',
            loop: true,
            autoplay: true,
            autoloadSegments: true,
            rendererSettings: {progressiveLoad: !1}
        })
    </script>
@endpush
