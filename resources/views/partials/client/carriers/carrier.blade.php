<div class="flex flex-wrap -m-2 lg:-m-4">
    @forelse($carriers as $user)
        <a href="{{ route('client.carriers.show', $user->getPath()) }}"
           class="p-2 lg:p-4 w-full sm:w-1/2 lg:{{ $lgSize ?? 'w-1/4' }}">
            <div class="rounded bg-center bg-cover pt-screen lg:pt-squire shadow-lg"
                 style="background-image: url('{{ $user->carrier_preview  }}');"></div>
            <div class="bg-white py-2 px-3 lg:py-3 lg:px-4 rounded mx-1 lg:mx-3 -mt-6 border-2 shadow-xl">
                <h3 class="text-lg lg:text-xl font-bold font-slab leading-tight mb-2">{{ $user->name }} {{$user->surname}}</h3>
                <p class="text-sm">{{ $user->type_car }} {{ $user->brand_car }}</p>
                @if($user->car_region)
                    <p class="text-sm">{{ $user->region_car->name }}</p>
                @endif
            </div>
        </a>
    @empty
        <div class="p-4 w-full text-center">
            @if(request()->anyFilled('search', 'region'))
                <h2 class="font-bold font-slab text-2xl">{{ __('carrier.not_found.title') }}</h2>
                <p>{{ __('carrier.not_found.description') }}</p>
            @else
                <h2 class="font-bold font-slab text-2xl">{{ __('carrier.empty') }}</h2>
            @endif
        </div>
    @endforelse
</div>
