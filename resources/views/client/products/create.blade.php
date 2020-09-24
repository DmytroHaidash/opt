@extends('layouts.app', ['title' => __('admin.products.title')])

@push('scripts')
    <script src="{{ asset('js/editor.js') }}" defer></script>
@endpush

@section('content')

    <section class="container my-6 lg:my-12">
        <form action="{{ route('client.profile.products.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="flex flex-wrap -mx-4">
                <div class="px-4 w-full">

                    <div class="form-group">
                        <label for="title-{{ app()->getLocale() }}" class="form-label">
                                    <span>
                                        {{ __('admin.fields.title') }}
                                    </span>
                        </label>
                        <input
                            id="title-{{ app()->getLocale() }}"
                            type="text"
                            name="title[{{ app()->getLocale() }}]"
                            class="form-control"
                            value="{{ old('title.' . app()->getLocale()) }}"
                        />
                    </div>

                    <div class="form-group">
                        <label for="content-{{ app()->getLocale() }}" class="form-label">
                                    <span>
                                        {{ __('admin.fields.content') }}
                                    </span>
                        </label>
                        <textarea
                            id="content-{{ app()->getLocale() }}"
                            name="content[{{ app()->getLocale() }}]"
                            rows="4"
                            id="content-{{ app()->getLocale() }}"
                            class="editor"
                        >{{ old('content.' . app()->getLocale()) }}</textarea>
                    </div>
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

                    <div class="mt-6">
                        <div class="form-checkbox">
                            <input type="checkbox" name="has_delivery"
                                   id="delivery" {{ old('has_delivery') ? 'checked' : '' }}>
                            <label for="delivery">{{ __('admin.products.fields.has_delivery') }}</label>
                        </div>

                        <div class="form-checkbox">
                            <input type="checkbox" name="has_pickup"
                                   id="pickup" {{ old('has_pickup', true) ? 'checked' : '' }}>
                            <label for="pickup">{{ __('admin.products.fields.has_pickup') }}</label>
                        </div>
                        <div class="form-checkbox">
                            <input type="checkbox" name="price_arranged"
                                   id="price_arranged" {{ old('price_arranged') ? 'checked' : '' }}>
                            <label for="price_arranged">{{ __('admin.products.fields.price_arranged') }}</label>
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
            </div>
        </form>
    </section>

@endsection
