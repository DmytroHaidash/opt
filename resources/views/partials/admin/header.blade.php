<header class="py-2 bg-white">
    <div class="px-6">
        <div class="flex items-center -mx-6">
            <div class="w-48 px-6 font-semibold text-sm">
                <a href="{{ url('/') }}" target="_blank">{{ __('admin.enter_site') }}</a>
            </div>

            <div class="flex-1 px-6">
                <form method="get" class="relative">
                    <svg class="absolute w-5 h-5 left-0 ml-3 inset-y-0 my-auto fill-current text-gray-500">
                        <use xlink:href="{{ asset('images/icons/admin.svg#search') }}"></use>
                    </svg>

                    <input type="search" name="search"
                           class="form-control pl-10"
                           value="{{ request('search') }}"
                           placeholder="{{ __('Поиск') }}"
                           onsearch="this.form.submit()"
                    >
                </form>
            </div>

            <div class="w-48 px-6 text-sm">
                <button class="font-semibold">{{ Auth::user()->name }} <span class="caret"></span></button>
            </div>
        </div>
    </div>
</header>
