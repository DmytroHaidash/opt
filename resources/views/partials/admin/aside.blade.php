<aside class="fixed w-56 h-screen bg-gray-100 py-2">
    <ul class="flex flex-col h-full max-h-full overflow-y-auto">
        @foreach(app('nav:admin')->routes() as $route)
            <li class="my-1 py-2 px-4 relative border-l-2{{ $route->match ? ' border-red-600 text-red-600' : '' }}">
                <a href="{{ $route->route }}" class="flex items-center hover:text-red-600">
                    <svg class="fill-current w-10 h-10">
                        <use xlink:href="{{ asset('images/icons/admin.svg#') . $route->icon }}"></use>
                    </svg>
                    <span class="ml-3 text-gray-800 font-bold font-slab">{{ $route->name }}</span>
                </a>

                @isset($route->unread)
                    <span
                        class="absolute w-5 h-5 text-xs font-bold bg-red-600 text-white left-0 ml-2 top-0 rounded-full flex justify-center items-center">
                        {{ $route->unread }}
                    </span>
                @endisset

                @isset($route->children)
                    <ul class="ml-10 text-sm"{{ !$route->match ? ' hidden' : '' }}>
                        @foreach($route->children as $child)
                            <li class="ml-1 my-1">
                                <a href="{{ $child->route }}"
                                   class="{{ isset($child->match) && $child->match ? 'font-semibold text-red-600' : 'text-gray-800' }}">
                                    {{ $child->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endisset
            </li>
        @endforeach

        <li class="mt-auto px-4 py-6 border-l-2 border-transparent">
            <a
                class="flex items-center hover:text-red-600"
                href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            >
                <svg class="fill-current w-10 h-10">
                    <use xlink:href="{{ asset('images/icons/admin.svg#link') }}"></use>
                </svg>
                <span class="ml-3 text-gray-800 font-bold font-slab">{{ __('Выйти') }}</span>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</aside>
