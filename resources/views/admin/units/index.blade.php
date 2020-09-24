@extends('layouts.admin', ['title' => __('admin.units.title')])

@section('content')

    <div class="flex items-center -mx-6 mb-6">
        <div class="px-6 flex-1">
            <h1 class="font-bold font-slab text-3xl">{{ __('admin.units.title') }}</h1>
        </div>

        <div class="px-6">
            <a href="{{ route('admin.units.create') }}" class="button button--primary button--sm">
                {{ __('admin.units.create') }}
            </a>
        </div>
    </div>

    <table class="w-full">
        <x-table-header/>

        @forelse($units as $unit)
            <tr>
                <td class="p-3">{{ $unit->id }}</td>
                <td class="p-3 w-1/2">{{ $unit->name }}</td>
                <td class="p-3 w-1/2">{{ $unit->nicename }}</td>
                <td class="p-3 w-8">
                    <x-table-actions
                        :edit="route('admin.units.edit', $unit)"
                        :delete="route('admin.units.destroy', $unit)"
                    />
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="p-3 text-center">{{ __('admin.not_found') }}</td>
            </tr>
        @endforelse
    </table>

    {{ $units->appends(request()->except('page'))->links() }}

    @includeIf('partials.admin.deletions')

@endsection
