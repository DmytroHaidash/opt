@extends('layouts.admin', ['page_title' => __('admin.settings.title')])

@section('content')

    <div class="flex items-center -mx-6 mb-6">
        <div class="px-6 flex-1">
            <h1 class="font-bold font-slab text-3xl">{{ __('admin.settings.title') }}</h1>
        </div>
    </div>

    <form action="{{ route('admin.settings.update', $setting) }}" method="post">
        @csrf
        @method('patch')
        <div class="form-group flex">
            <div class="px-2 w-1/2">
                <label for="ads_per_day" class="form-label"><span>{{ __('admin.fields.ads_per_day') }}</span></label>
                <input name="ads_per_day" id="ads_per_day" type="number" class="form-control" step="1"
                       min="1" value="{{$setting->ads_per_day ?? 1}}" required>
            </div>
            <div class="px-2 w-1/2">
                <label for="ads_live_day" class="form-label"><span>{{ __('admin.fields.ads_live_day') }}</span></label>
                <input name="ads_live_day" id="ads_live_day" type="number" class="form-control" step="1"
                       min="1" value="{{$setting->ads_live_day ?? 1}}" required>
            </div>
        </div>

        <div class="mt-10 flex items-center">
            <button class="button button--primary">{{ __('admin.buttons.save') }}</button>
        </div>

    </form>


@endsection
