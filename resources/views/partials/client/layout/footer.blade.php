<footer id="app-footer" class="bg-gray-800 text-gray-50 text-sm pt-4 lg:pt-12 relative z-30">
    <div class="container">
        <div class="flex flex-wrap -mx-6">
            <div class="px-6 w-full lg:w-1/3 mb-6 lg:mb-0">
                <svg class="h-8 mx-auto lg:mx-0" viewBox="0 0 385 54" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M26.944 8.208H45.88V0.287996H0.16V8.208H19.312V54H26.944V8.208ZM64.0465 46.512V40.608C67.2865 38.88 68.8705 38.448 75.7105 38.448H81.1825V31.032H75.7105C71.3905 31.032 67.2865 31.32 64.0465 33.192V24.12H86.0785V16.704H56.7025V54H87.4465V46.512H64.0465ZM129.14 54H136.484V16.704H101.492V54H108.836V24.12H129.14V54ZM154.238 24.12H160.286C159.638 31.248 159.134 36.432 155.39 42.408C153.302 45.72 151.43 46.512 149.918 46.512H147.974V54H151.79C153.662 54 157.118 53.712 159.638 50.76C165.182 44.208 167.27 33.12 168.134 24.12H178.574V54H186.422V16.704H151.07L154.238 24.12ZM232.814 16.704L211.07 43.488V16.704H203.726V54H211.07L232.814 27.072V54H240.158V16.704H232.814ZM304.031 54H334.919V46.512H313.823L333.479 24.12V16.704H304.751V24.12H323.687L304.031 46.512V54ZM356.795 15.84L359.243 20.52L341.387 54H349.163L349.379 53.568C350.603 51.984 360.179 48.384 369.395 48.384H373.859L376.811 54H384.947L364.787 15.84H356.795ZM369.323 41.616C361.619 41.616 356.579 43.632 354.203 44.856L363.059 27.792L370.331 41.616H369.323Z" fill="#ffffff"/>
                    <path d="M252.405 54H296.109V46.152H262.197L293.445 7.92V0.287996H254.061V8.208H282.645L252.405 46.08V54Z" fill="#DD6B20"/>
                </svg>
            </div>
            <div class="px-6 w-full sm:w-1/2 lg:w-1/3">
                <h3 class="font-bold font-slab mb-3">{{ __('О проекте') }}</h3>
                <ul>
                    @foreach(app('nav:client')->footer() as $nav)
                        <li class="my-1">
                            <a
                                href="{{ $nav->route }}"
                                class="border-b border-gray-700 hover:border-gray-600 transition duration-300"
                            >{{ $nav->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="px-6 w-full sm:w-1/2 lg:w-1/3">
                <h3 class="font-bold font-slab mb-3">{{ __('Контактная информация') }}</h3>
                <p>Ярослав Крыль</p>
                <ul>
                    <li class="my-1">
                        <a href="tel:+380504567404" >+38 050 456-74-04</a>
                    </li>
                </ul>
                <ul>
                    <li class="my-1">
                        <a href="mailto:yaroslav.kryl@gmail.com">yaroslav.kryl@gmail.com</a>
                    </li>
                </ul>
                <ul>
                    <li class="my-1">
                        <a href="https://www.facebook.com/profile.php?id=100003465426851">Facebook</a>
                    </li>
                </ul>
                <ul>
                    <li class="my-1">
                        <a href="https://platformazp.com.ua/contacts/">Платформа спільних дій</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="py-3 border-t-2 border-gray-700 mt-4 lg:mt-12 flex flex-wrap text-xs">
            <div>&copy; {{ date('Y') }} {{ config('app.name') }}</div>
            <div class="ml-auto">
                {{ __('Разработано в') }}
                <a href="https://impressionbureau.pro" class="font-bold border-b" target="_blank">ImpressionBureau</a>
                <sup>2020</sup>
            </div>
        </div>
    </div>
</footer>
