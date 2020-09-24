<header id="app-header" class="py-2 sticky top-0 bg-white z-50 shadow-md">
    <div class="container text-sm">
        <div class="flex items-center -mx-3 lg:-mx-6">
            <div class="px-2 lg:px-6">
                <a href="{{ url('/') }}" class="font-bold text-xl">
                    <svg class="h-6" viewBox="0 0 385 54" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M26.944 8.208H45.88V0.287996H0.16V8.208H19.312V54H26.944V8.208ZM64.0465 46.512V40.608C67.2865 38.88 68.8705 38.448 75.7105 38.448H81.1825V31.032H75.7105C71.3905 31.032 67.2865 31.32 64.0465 33.192V24.12H86.0785V16.704H56.7025V54H87.4465V46.512H64.0465ZM129.14 54H136.484V16.704H101.492V54H108.836V24.12H129.14V54ZM154.238 24.12H160.286C159.638 31.248 159.134 36.432 155.39 42.408C153.302 45.72 151.43 46.512 149.918 46.512H147.974V54H151.79C153.662 54 157.118 53.712 159.638 50.76C165.182 44.208 167.27 33.12 168.134 24.12H178.574V54H186.422V16.704H151.07L154.238 24.12ZM232.814 16.704L211.07 43.488V16.704H203.726V54H211.07L232.814 27.072V54H240.158V16.704H232.814ZM304.031 54H334.919V46.512H313.823L333.479 24.12V16.704H304.751V24.12H323.687L304.031 46.512V54ZM356.795 15.84L359.243 20.52L341.387 54H349.163L349.379 53.568C350.603 51.984 360.179 48.384 369.395 48.384H373.859L376.811 54H384.947L364.787 15.84H356.795ZM369.323 41.616C361.619 41.616 356.579 43.632 354.203 44.856L363.059 27.792L370.331 41.616H369.323Z" fill="#2D3748"/>
                        <path d="M252.405 54H296.109V46.152H262.197L293.445 7.92V0.287996H254.061V8.208H282.645L252.405 46.08V54Z" fill="#DD6B20"/>
                    </svg>
                </a>
            </div>

            <div class="px-2 lg:px-6 lg:flex-1">
                <div class="lg:hidden w-5">
                    <dropdown position="center" v-cloak>
                        <div class="dropdown-button" slot="button" slot-scope="{toggle}">
                            <button class="block lg:hidden" @click.prevent="toggle">
                                <svg class="w-5 h-5 fill-current">
                                    <use xlink:href="{{ asset('images/icons/client.svg#menu') }}"></use>
                                </svg>
                            </button>
                        </div>

                        <ul slot="menu">
                            @foreach(app('nav:client')->header() as $nav)
                                <li class="py-2">
                                    <a href="{{ $nav->route }}" class="px-2{{ $nav->match ? ' font-bold' : '' }}">
                                        {{ $nav->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </dropdown>
                </div>

                <nav class="hidden lg:flex">
                    @foreach(app('nav:client')->header() as $nav)
                        <a href="{{ $nav->route }}" class="px-2{{ $nav->match ? ' font-bold' : '' }}">
                            {{ $nav->name }}
                        </a>
                    @endforeach
                </nav>
            </div>

            <div class="px-4 hidden sm:block whitespace-no-wrap ml-auto">
                @includeIf('partials.client.layout.locales')
            </div>

            <div class="px-3 lg:px-6">
                <cart-button route="{{ route('client.cart.index') }}"></cart-button>
            </div>

            <div class="pr-3 lg:pr-6 max-w-xxs">
                <dropdown position="right">
                    <div class="dropdown-button" slot="button" slot-scope="{toggle}">
                        <button @click.prevent="toggle" class="font-bold font-slab flex items-center">
                            <img src="{{ Auth::check() ? Auth::user()->avatar : asset('images/no-avatar.png') }}"
                                class="w-8 h-8 rounded" alt="">
                        </button>
                    </div>

                    <template slot="menu">
                        <ul>
                            @auth
                                <li class="pb-2 border-b">
                                    <strong>{{ Auth::user()->name }}</strong>
                                </li>

                                @foreach(app('nav:client')->dropdown() as $item)
                                    <li class="pt-2">
                                        <a href="{{ $item->route }}" class="{{ $item->match ? 'font-bold' : '' }}">
                                            {{ $item->name }}
                                        </a>
                                    </li>
                                @endforeach

                                <li class="pt-2 mt-2 border-t">
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout').submit()">
                                        {{ __('auth.logout') }}
                                    </a>
                                    <form action="{{ route('logout') }}" method="post" id="logout" hidden>
                                        @csrf
                                    </form>
                                </li>
                            @else
                                <li class="py-2 text-center">
                                    <a href="{{ route('register') }}"
                                       class="button button--primary-outline">{{ __('auth.register') }}</a>
                                </li>

                                <li class="py-2 text-center">
                                    <a href="{{ route('login') }}"
                                       class="button button--primary px-4 h-10">{{ __('auth.login') }}</a>
                                </li>
                            @endauth

                            <li class="pt-2 mt-3 border-t sm:hidden text-center">
                                @includeIf('partials.client.layout.locales')
                            </li>
                        </ul>
                    </template>
                </dropdown>
            </div>
        </div>
    </div>
</header>
