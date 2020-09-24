@extends('layouts.admin', ['title' => __('admin.articles.title')])

@push('scripts')
    <script src="{{ asset('js/editor.js') }}" defer></script>
@endpush

@section('content')

    <form action="{{ route('admin.articles.update', $article) }}" method="post">
        @csrf
        @method('patch')

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
                            value="{{ old('title.'.$locale) ?? $article->getTranslation('title', $locale) }}"
                        />
                    </div>

                    <div class="form-group">
                        <label for="description-{{ $locale }}" class="form-label">
                            <span>
                                {{ __('admin.fields.description') }}
                                {{ __('admin.fields.optional') }}
                                <span class="uppercase text-gray-400">({{ $locale }})</span>
                            </span>
                        </label>
                        <textarea
                            id="description-{{ $locale }}"
                            name="description[{{ $locale }}]"
                            rows="4"
                            id="description-{{ $locale }}"
                            class="form-control"
                        >{{ old('description.'.$locale) ?? $article->getTranslation('description', $locale) }}</textarea>
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
                        >{{ old('content.'.$locale) ?? $article->getTranslation('content', $locale) }}</textarea>
                    </div>
                </fieldset>
            @endforeach
        </locales>

        <div class="flex -mx-6 items-center">
            <div class="px-6 w-auto">
                <div class="form-group">
                    <label for="published_at" class="form-label">
                        <span>{{ __('admin.fields.published_at') }}</span>
                    </label>
                    <input
                        id="published_at"
                        type="datetime-local"
                        name="published_at"
                        class="form-control"
                        value="{{ old('published_at') ?? optional($article->published_at)->format('Y-m-d\TH:i') }}"
                    />
                </div>
            </div>

            <div class="px-6 pt-3">
                <div class="form-checkbox">
                    <input type="checkbox" name="is_published" id="published" {{ $article->published_at ? 'checked' : '' }}>
                    <label for="published">{{ __('admin.fields.is_published') }}</label>
                </div>
            </div>
        </div>

        <div class="mt-10">
            <button class="button button--primary">{{ __('admin.buttons.save') }}</button>
            <a href="{{ route('admin.articles.index', ['taxonomy' => request('taxonomy')]) }}" class="button">
                {{ __('admin.buttons.cancel') }}
            </a>
        </div>
    </form>

@endsection
