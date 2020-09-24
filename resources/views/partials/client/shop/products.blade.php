<div class="flex flex-wrap -m-2 lg:-m-4">
    @forelse($products as $product)
        <a href="{{ route('client.products.show', $product->getPath()) }}" class="p-2 lg:p-4 w-full sm:w-1/2 lg:{{ $lgSize ?? 'w-1/4' }}">
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
    @empty
        <div class="p-4 w-full text-center">
            @if(request()->anyFilled('search', 'city', 'category'))
                <h2 class="font-bold font-slab text-2xl">{{ __('shop.not_found.title') }}</h2>
                <p>{{ __('shop.not_found.description') }}</p>
            @else
                <h2 class="font-bold font-slab text-2xl">{{ __('shop.empty') }}</h2>
            @endif
        </div>
    @endforelse
</div>
