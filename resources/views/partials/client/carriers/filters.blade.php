<div class="sm:hidden mb-6">
    <button class="flex justify-center items-center font-bold border-2 rounded-full px-6 mx-auto h-12"
            @click.prevent="toggle">
        <svg class="fill-current w-4 h-4 mr-2 text-gray-500">
            <use xlink:href="{{ asset('images/icons/client.svg#filter') }}"></use>
        </svg>
        {{ __('Фильтр') }}
    </button>
</div>

<form action="{{ route('client.carriers.search') }}" method="post"
      class="filters sm:block" :class="{'hidden': !filters}">
    @csrf

    <div class="relative form-group">
        <svg class="absolute w-5 h-5 left-0 ml-3 inset-y-0 my-auto fill-current text-gray-500">
            <use xlink:href="{{ asset('images/icons/admin.svg#search') }}"></use>
        </svg>

        <input type="search" name="search"
               class="form-control pl-10"
               value="{{ request('search') }}"
               placeholder="{{ __('Поиск') }}"
               onsearch="this.form.submit()"
        />
    </div>

    <div class="form-group">
        <label for="car_region" class="form-label">
            <span>{{ __('shop.region') }}</span>
        </label>

        <select name="region" id="region" class="form-control">
            <option value="" disabled selected></option>
            @foreach($regions as $region)
                <option
                    value="{{ $region->id }}"
                    {{ $region->id == request('region') ? 'selected' : '' }}
                >
                    {{ $region->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mt-6 text-center">
        <button class="button button--primary p-0 w-full">
            {{ __('filters.button') }}
        </button>

        @if (request()->anyFilled('search', 'region'))
            <div class="mt-2">
                <a href="{{ url()->current() }}" class="text-gray-500 font-bold text-sm">
                    {{ __('filters.reset') }}
                </a>
            </div>
        @endif
    </div>
</form>
