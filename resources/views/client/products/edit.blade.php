@extends('layouts.app', ['title' => __('admin.products.title')])

@push('scripts')
    <script src="{{ asset('js/editor.js') }}" defer></script>
@endpush

@section('content')

    <section class="container my-6 lg:my-12">
        <form action="{{ route('client.profile.products.update', $product) }}" method="post"
              enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="flex flex-wrap -mx-6">
                <div class="px-4 w-full">
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
                                        value="{{ old('title.' . $locale) ?? $product->getTranslation('title', $locale) }}"
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
                                    >{{ old('content.' . $locale) ?? $product->getTranslation('content', $locale) }}</textarea>
                                </div>
                            </fieldset>
                        @endforeach
                    </locales>
                    <categories-select :trans="{{ json_encode(__('admin.products.fields'))}}"
                                       category="{{ $product->categories->whereNull('parent_id')->pluck('id')->first() }}"
                                       subcategory="{{ $product->categories->whereNotNull('parent_id')->pluck('id')->first() }}"
                                       :required="true"
                    ></categories-select>
                    <regions-cities-select
                        region="{{ $product->city->region_id ?? old('region_id')  }}"
                        city="{{ $product->city->id ?? old('city_id')  }}"
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
                            value="{{ old('address') ?? $product->address}}"
                        />
                    </div>

                    <product-values
                        class="mt-6"
                        :values="{{ json_encode(\App\Http\Resources\ProductValue::collection($product->values)) }}"
                        :trans="{{ json_encode(array_merge(__('admin.products.fields'), __('admin.buttons'))) }}"
                        :units="{{ $units }}"
                    ></product-values>

                    <media-upload
                        class="mt-6"
                        label="{{ __('admin.buttons.upload') }}"
                        :items="{{ json_encode($product->uploads) }}"
                    ></media-upload>

                    <div class="mt-6">
                        <div class="form-checkbox">
                            <input type="checkbox" name="has_delivery"
                                   id="delivery" {{ old('has_delivery') ?? $product->has_delivery ? 'checked' : '' }}>
                            <label for="delivery">{{ __('admin.products.fields.has_delivery') }}</label>
                        </div>

                        <div class="form-checkbox">
                            <input type="checkbox" name="has_pickup"
                                   id="pickup" {{ old('has_pickup') ?? $product->has_pickup ? 'checked' : '' }}>
                            <label for="pickup">{{ __('admin.products.fields.has_pickup') }}</label>
                        </div>
                        <div class="form-checkbox">
                            <input type="checkbox" name="price_arranged"
                                   id="price_arranged" {{ old('price_arranged') ?? $product->price_arranged ? 'checked' : '' }}>
                            <label for="price_arranged">{{ __('admin.products.fields.price_arranged') }}</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-10 flex items-center">
                <button class="button button--primary">{{ __('admin.buttons.save') }}</button>

                <div class="form-checkbox ml-8 mb-0">
                    <input type="checkbox" name="is_published"
                           id="published" {{$product->is_published ? 'checked' : ''}}>
                    <label for="published">{{ __('admin.fields.is_published') }}</label>
                </div>
            </div>
        </form>
    </section>

@endsection
