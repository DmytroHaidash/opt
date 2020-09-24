@extends('layouts.admin', ['title' => __('admin.pages.title')])

@push('scripts')
    <script src="{{ asset('js/editor.js') }}" defer></script>
@endpush

@section('content')

    <form action="{{ route('admin.pages.update', $page) }}" method="post">
        @csrf
        @method('patch')
        <input type="hidden" name="page_id" value="{{ $page->id }}">

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
                            value="{{ old('title.'.$locale) ?? $page->getTranslation('title', $locale) }}"
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
                        >{{ old('content.'.$locale) ?? $page->getTranslation('content', $locale) }}</textarea>
                    </div>
                </fieldset>
            @endforeach
        </locales>

        {{-- @includeIf('admin.pages.partials.slug') --}}

        <div class="mt-10">
            <button class="button button--primary">{{ __('admin.buttons.save') }}</button>
            <a href="{{ route('admin.pages.index', ['taxonomy' => request('taxonomy')]) }}" class="button">
                {{ __('admin.buttons.cancel') }}
            </a>
        </div>
    </form>

@endsection
