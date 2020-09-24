@extends('layouts.admin', ['title' => __('admin.categories.title')])

@section('content')

    <form action="{{ route('admin.categories.store') }}" method="post">
        @csrf
        <input type="hidden" name="taxonomy" value="{{ request('taxonomy') }}">

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
                            value="{{ old('title.'.$locale) }}"
                        />
                    </div>

                    <div class="form-group">
                        <label for="description-{{ $locale }}" class="form-label">
                            <span>
                                {{ __('admin.fields.description') }}
                                <span class="uppercase text-gray-400">({{ $locale }})</span>
                            </span>
                        </label>
                        <textarea
                            id="description-{{ $locale }}"
                            name="description[{{ $locale }}]"
                            rows="4"
                            id="description-{{ $locale }}"
                            class="form-control"
                        >{{ old('description.'.$locale) }}</textarea>
                    </div>
                </fieldset>
            @endforeach
        </locales>

        <div class="form-group">
            <label for="parent" class="form-label">
                <span>{{ __('admin.categories.fields.parent') }}</span>
            </label>
            <select name="parent_id" id="parent" class="form-control">
                <option value="">-----</option>
                @foreach($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        {{ $category->id === old('parent_id') ? 'selected' : '' }}
                    >{{ $category->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="mt-10">
            <button class="button button--primary">{{ __('admin.buttons.save') }}</button>
            <a href="{{ route('admin.categories.index', ['taxonomy' => request('taxonomy')]) }}" class="button">
                {{ __('admin.buttons.cancel') }}
            </a>
        </div>
    </form>

@endsection
