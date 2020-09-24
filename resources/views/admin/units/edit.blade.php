@extends('layouts.admin', ['title' => __('admin.units.title')])

@section('content')

    <form action="{{ route('admin.units.update', $unit) }}" method="post">
        @csrf
        @method('patch')

        <locales v-slot="{current}">
            @foreach(config('translatable.locales') as $locale)
                <fieldset v-show="current === '{{ $locale }}'">
                    <div class="form-group">
                        <label for="name-{{ $locale }}" class="form-label">
                            <span>
                                {{ __('admin.units.fields.name') }}
                                <span class="uppercase text-gray-400">({{ $locale }})</span>
                            </span>
                        </label>
                        <input
                            id="name-{{ $locale }}"
                            type="text"
                            name="name[{{ $locale }}]"
                            class="form-control"
                            value="{{ old('name.'.$locale) ?? $unit->getTranslation('name', $locale) }}"
                        />
                    </div>

                    <div class="form-group">
                        <label for="nicename-{{ $locale }}" class="form-label">
                            <span>
                                {{ __('admin.units.fields.nicename') }}
                                <span class="uppercase text-gray-400">({{ $locale }})</span>
                            </span>
                        </label>
                        <input
                            id="nicename-{{ $locale }}"
                            type="text"
                            name="nicename[{{ $locale }}]"
                            class="form-control"
                            value="{{ old('nicename.'.$locale) ?? $unit->getTranslation('nicename', $locale) }}"
                        />
                    </div>
                </fieldset>
            @endforeach
        </locales>

        <div class="mt-10">
            <button class="button button--primary">{{ __('admin.buttons.save') }}</button>
            <a href="{{ route('admin.units.index') }}" class="button">
                {{ __('admin.buttons.cancel') }}
            </a>
        </div>
    </form>

@endsection
