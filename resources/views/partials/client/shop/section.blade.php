<section class="py-12 {{ $container ?? '' }}">
    <div class="container">
        <x-section-title :route="route('client.products.index')">{{ __('Магазин') }}</x-section-title>

        @includeIf('partials.client.shop.products')
    </div>
</section>
