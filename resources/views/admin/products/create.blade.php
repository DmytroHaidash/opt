@extends('layouts.admin', ['title' => __('admin.products.title')])

@push('scripts')
    <script src="{{ asset('js/editor.js') }}" defer></script>
@endpush

@section('content')

    <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="flex -mx-4">
            <div class="w-full px-4">
                <locales v-slot="{current}">
                    @foreach(config('translatable.locales') as $locale)
                        <fieldset v-show="current === '{{ $locale }}'">
                            <div class="form-group">
                                <label for="title-{{ $locale }}" class="form-label">
                                    <span>
                                        {{ __('admin.fields.title') }}
                                        <span class="uppercase text-gray-400">({{ $locale }})</span>
                                    </span>
                                </label>
                                <input
                                    id="title-{{ $locale }}"
                                    type="text"
                                    name="title[{{ $locale }}]"
                                    class="form-control"
                                    value="{{ old('title.' . $locale) }}"
                                />
                            </div>

                            <div class="form-group">
                                <label for="content-{{ $locale }}" class="form-label">
                                    <span>
                                        {{ __('admin.fields.content') }}
                                        <span class="uppercase text-gray-400">({{ $locale }})</span>
                                    </span>
                                </label>
                                <textarea
                                    id="content-{{ $locale }}"
                                    name="content[{{ $locale }}]"
                                    rows="4"
                                    id="content-{{ $locale }}"
                                    class="editor"
                                >{{ old('content.' . $locale) }}</textarea>
                            </div>
                        </fieldset>
                    @endforeach
                </locales>
                <categories-select :trans="{{ json_encode(__('admin.products.fields'))}}"
                    :required="true"></categories-select>
                <regions-cities-select
                    region="{{ old('region_id')  }}"
                    city="{{ old('city_id')  }}"
                ></regions-cities-select>
                <div class="form-group">
                    <label for="address" class="form-label">
                        <span>{{ __('admin.fields.address') }}</span>
                    </label>
                    <input
                        id="address"
                        type="text"
                        name="address"
                        class="form-control"
                        value="{{ old('address') }}"
                    />
                </div>
                <product-values
                    class="mt-6"
                    :trans="{{ json_encode(array_merge(__('admin.products.fields'), __('admin.buttons'))) }}"
                    :units="{{ $units }}"
                ></product-values>

                <media-upload class="mt-6" label="{{ __('admin.buttons.upload') }}"></media-upload>
                {{--@includeIf('admin.products.partials.categories')--}}

                <div class="mt-6">
                    <div class="form-checkbox">
                        <input type="checkbox" name="has_delivery"
                               id="delivery" {{ old('has_delivery') ? 'checked' : '' }}>
                        <label for="delivery">{{ __('admin.products.fields.has_delivery') }}</label>
                    </div>

                    <div class="form-checkbox">
                        <input type="checkbox" name="has_pickup"
                               id="pickup" {{ old('has_pickup') ?? true ? 'checked' : '' }}>
                        <label for="pickup">{{ __('admin.products.fields.has_pickup') }}</label>
                    </div>
                    <div class="form-checkbox">
                        <input type="checkbox" name="price_arranged"
                               id="price_arranged" {{ old('price_arranged') ? 'checked' : '' }}>
                        <label for="price_arranged">{{ __('admin.products.fields.price_arranged') }}</label>
                    </div>

                    {{--
                    <conditional :approved="{{ old('has_pickup') ?? true ? 1 : 0 }}" inline-template>
                        <fieldset>
                            <div class="form-checkbox">
                                <input
                                    type="checkbox"
                                    name="has_pickup"
                                    id="pickup"
                                    @change="toggle"
                                    {{ old('has_pickup') ?? true ? 'checked' : '' }}
                                >
                                <label for="pickup">{{ __('admin.products.fields.has_pickup') }}</label>
                            </div>

                            <div class="form-group" v-if="isApproved">
                                <label for="latitude" class="form-label">
                                    <span>{{ __('admin.fields.latitude') }}</span>
                                </label>
                                <input
                                    id="latitude"
                                    type="text"
                                    name="latitude"
                                    class="form-control"
                                    value="{{ old('latitude') }}"
                                />
                            </div>

                            <div class="form-group" v-if="isApproved">
                                <label for="longitude" class="form-label">
                                    <span>{{ __('admin.fields.longitude') }}</span>
                                </label>
                                <input
                                    id="longitude"
                                    type="text"
                                    name="longitude"
                                    class="form-control"
                                    value="{{ old('longitude') }}"
                                />
                            </div>
                        </fieldset>
                    </conditional>
                    --}}
                </div>
            </div>
        </div>

        <div class="mt-10 flex items-center">
            <button class="button button--primary">{{ __('admin.buttons.save') }}</button>

            <div class="form-checkbox ml-8 mb-0">
                <input type="checkbox" name="is_published" id="published" checked>
                <label for="published">{{ __('admin.fields.is_published') }}</label>
            </div>
        </div>
    </form>

@endsection
