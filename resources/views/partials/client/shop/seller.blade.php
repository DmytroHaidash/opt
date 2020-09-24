<div class="px-6 py-5 bg-gray-100 rounded overflow-hidden lg:sticky" style="top: 5rem">
    <h3 class="text-lg mb-2 font-bold font-slab">{{ $product->user->name }}
        @auth
            <favourites
                {{ $product->user->in_favorites ? 'checked' : '' }}
                class="absolute hover:text-orange-600 transition duration-300"
                type="{{ \App\Models\User::class }}"
                model="{{ $product->user->id }}"
            ></favourites>
        @endauth</h3>
    <p class="text-lg mt-2 flex items-center">
        <svg class="w-4 h-4 fill-current mr-2">
            <use xlink:href="{{ asset('images/icons/client.svg#call') }}"></use>
        </svg>
        <a href="tel:{{ $product->user->phone }}"
           class="border-b border-dashed border-gray-400 hover:border-gray-600">
            +{{ $product->user->phone }}
        </a>
    </p>
    <p class="mt-2 flex items-center">
        <svg class="w-4 h-4 fill-current mr-2">
            <use xlink:href="{{ asset('images/icons/client.svg#email') }}"></use>
        </svg>
        <a href="mailto:{{ $product->user->email }}"
           class="border-b border-dashed border-gray-400 hover:border-gray-600">
            {{ $product->user->email }}
        </a>
    </p>

    @if ($product->has_delivery || $product->has_pickup)
        <hr class="mt-6 mb-4 border-gray-300 -mx-4">

        @if ($product->city)
            <h3 class="font-bold font-slab text-xl mb-4">
                {{ __('shop.city', ['city' => optional($product->city)->name]) }}
            </h3>
            @if ($product->address)
                <div>{{ $product->address }}</div>
                <hr class="my-4 border-gray-300 -mx-4">
            @endif
        @endif

        @if($product->has_pickup)
            <div class="flex items-center">
                <svg class="w-4 h-4 fill-current mr-2">
                    <use xlink:href="{{ asset('images/icons/client.svg#pin') }}"></use>
                </svg>
                {{ __('shop.has_pickup') }}
            </div>

        @endif

        @if($product->has_delivery)
            <div class="flex items-center">
                <svg class="w-4 h-4 fill-current mr-2">
                    <use xlink:href="{{ asset('images/icons/client.svg#map') }}"></use>
                </svg>
                {{ __('shop.has_delivery') }}
            </div>
        @endif

        @if ($product->city)
            <hr class="my-4 border-gray-300 -mx-4">

            <div>{{ $product->city->region->name }}</div>
        @endif
    @endif
</div>
