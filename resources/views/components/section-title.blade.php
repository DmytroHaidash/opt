<div class="flex items-center mb-8">
    <h2 class="border-l-4 border-orange-600 pl-4 pr-6 text-3xl font-slab font-bold">{{ $slot }}</h2>
    <div>
        <a href="{{ $route }}" class="button button--gray-outline rounded-full text-sm font-bold font-slab px-6 py-2 whitespace-no-wrap inline-flex items-center transition duration-300">
            {{ __('В раздел') }}
            <svg class="fill-current w-3 h-3 ml-4">
                <use xlink:href="{{ asset('images/icons/client.svg#arrow-right') }}"></use>
            </svg>
        </a>
    </div>
</div>
