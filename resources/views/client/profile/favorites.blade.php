@extends('layouts.app', ['title' => __('nav.profile.favorites')])

@section('content')

    <section class="my-6 lg:my-12 container">
        @includeIf('client.profile.partials.nav')
        @if($carriers || $products || $sellers)
            @if($products)
                <div class="px-6 flex-1">
                    <h1 class="font-bold font-slab text-3xl">{{ __('admin.products.title') }}</h1>
                </div>
                <div class="flex flex-wrap -m-4">
                    @foreach($products as $item)
                        @if($item->favoritable)
                            <a href="{{ route('client.products.show', $item->favoritable->getPath()) }}"
                               class="p-4 w-full sm:w-1/2 lg:w-1/4">
                                <div class="rounded bg-center bg-cover pt-portrait shadow-lg"
                                     style="background-image: url('{{ $item->favoritable->cover }}');"></div>
                                <div class="bg-white py-3 px-4 rounded mx-3 -mt-6 border-2 shadow-xl">
                                    <h3 class="text-xl font-bold font-slab leading-tight mb-2">
                                        {{ $item->favoritable->title }}
                                    </h3>

                                    @foreach($item->favoritable->values as $value)
                                        <p class="text-sm">
                                            <strong>{{ number_format($value->price, 2, ',', ' ') }} грн</strong>
                                            {{ __('от') }}
                                            {{ number_format($value->min, 0, ',', ' ') }}
                                            {{ $value->unit->name }}
                                        </p>
                                    @endforeach

                                    <p class="text-sm font-bold font-slab mt-3">
                                        {{ $item->favoritable->user->name }}
                                    </p>

                                    @if ($item->favoritable->has_delivery)
                                        <p class="text-sm">
                                            {!! __('shop.delivery_from', ['city' => $item->favoritable->user->city->name]) !!}
                                        </p>
                                    @endif
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>
            @endif
            @if($carriers)
                    <div class="px-6 flex-1 ">
                        <h1 class="font-bold font-slab text-3xl">{{ __('Перевозчики') }}</h1>
                    </div>
                    <div class="flex flex-wrap -m-4">
                        @foreach($carriers as $item)
                            <a href="{{ route('client.carriers.show', $item->favoritable->getPath()) }}"
                               class="p-4 w-full sm:w-1/2 lg:w-1/4">
                                <div class="rounded bg-center bg-cover pt-portrait shadow-lg"
                                     style="background-image: url('{{ $item->favoritable->carrier_preview }}');"></div>
                                <div class="bg-white py-3 px-4 rounded mx-3 -mt-6 border-2 shadow-xl">
                                    <h3 class="text-xl font-bold font-slab leading-tight mb-2">
                                        {{ $item->favoritable->name }} {{$item->favoritable->surname}}
                                    </h3>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
                @if($sellers)
                    <div class="px-6 flex-1 ">
                        <h1 class="font-bold font-slab text-3xl">{{ __('Продавцы') }}</h1>
                    </div>
                    <div class="flex flex-wrap -m-4">
                        @foreach($sellers as $item)
                            <a href="{{ route('client.sellers.show', $item->favoritable->getPath()) }}"
                               class="p-4 w-full sm:w-1/2 lg:w-1/4">
                                <div class="rounded bg-center bg-cover pt-portrait shadow-lg"
                                     style="background-image: url('{{ $item->favoritable->carrier_preview }}');"></div>
                                <div class="bg-white py-3 px-4 rounded mx-3 -mt-6 border-2 shadow-xl">
                                    <h3 class="text-xl font-bold font-slab leading-tight mb-2">
                                        {{ $item->favoritable->name }} {{$item->favoritable->surname}}
                                    </h3>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif

        @else
            <h2 class="text-xl font-bold font-slab mb-6 text-center">
                {{ __('favorites.empty') }}
            </h2>
        @endif
    </section>
@endsection
