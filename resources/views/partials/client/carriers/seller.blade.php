<div class="px-6 py-5 bg-gray-100 rounded overflow-hidden lg:sticky" style="top: 5rem">
    <h3 class="text-lg mb-2 font-bold font-slab">{{ $carrier->name }}</h3>
    <p class="text-lg mt-2 flex items-center">
        <svg class="w-4 h-4 fill-current mr-2">
            <use xlink:href="{{ asset('images/icons/client.svg#call') }}"></use>
        </svg>
        <a href="tel:{{ $carrier->phone }}"
           class="border-b border-dashed border-gray-400 hover:border-gray-600">
            +{{ $carrier->phone }}
        </a>
    </p>
    <p class="mt-2 flex items-center">
        <svg class="w-4 h-4 fill-current mr-2">
            <use xlink:href="{{ asset('images/icons/client.svg#email') }}"></use>
        </svg>
        <a href="mailto:{{ $carrier->email }}"
           class="border-b border-dashed border-gray-400 hover:border-gray-600">
            {{ $carrier->email }}
        </a>
    </p>
</div>
