<div class="sm:hidden mb-6">
    <button class="flex justify-center items-center font-bold border-2 rounded-full px-6 mx-auto h-12"
            @click.prevent="toggle">
        <svg class="fill-current w-4 h-4 mr-2 text-gray-500">
            <use xlink:href="{{ asset('images/icons/client.svg#filter') }}"></use>
        </svg>
        {{ __('Фильтр') }}
    </button>
</div>

<form action="{{ route('client.products.search') }}" method="post"
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
    <categories-select :trans="{{ json_encode(__('admin.products.fields'))}}"
                       category="{{ request('category') }}"
                       subcategory="{{ request('subcategory') }}"
                       :required="false"
    ></categories-select>

    <regions-cities-select
        region="{{ request('region_id') }}"
        city="{{ request('city_id') }}"
    ></regions-cities-select>

    <div class="form-group">
        <label for="price" class="form-label">
            <span>{{ __('filters.price.title') }}</span>
        </label>
        <select name="price" id="price" class="form-control">
            <option value="">{{ __('filters.price.any') }}</option>
            @foreach(['asc', 'desc'] as $direction)
                <option
                    value="{{ $direction }}"
                    {{ $direction == request('price') ? 'selected' : '' }}
                >{{ __('filters.price.' . $direction) }}</option>
            @endforeach
        </select>
    </div>

    {{--    <price-range min="0" max="1000"></price-range>--}}

    <div class="mt-6 text-center">
        <button class="button button--primary p-0 w-full">
            {{ __('filters.button') }}
        </button>

        @if (request()->anyFilled('search', 'city', 'category'))
            <div class="mt-2">
                <a href="{{ url()->current() }}" class="text-gray-500 font-bold text-sm">
                    {{ __('filters.reset') }}
                </a>
            </div>
        @endif
    </div>
</form>
