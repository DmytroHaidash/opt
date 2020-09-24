@extends('layouts.admin', ['title' => __('admin.pages.title')])

@section('content')

    <div class="flex items-center -mx-6 mb-6">
        <div class="px-6 flex-1">
            <h1 class="font-bold font-slab text-3xl">{{ __('admin.pages.title') }}</h1>
        </div>
    </div>

    <table class="w-full">
        <x-table-header/>

        @forelse($pages as $page)
            <tr>
                <td class="p-3">{{ $page->id }}</td>
                <td class="p-3 w-full">{{ $page->title }}</td>
                <td class="p-3 w-8">
                    <x-table-actions
                        :edit="route('admin.pages.edit', $page)"
                    />
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="p-3 text-center">{{ __('admin.not_found') }}</td>
            </tr>
        @endforelse
    </table>

    {{ $pages->appends(request()->except('page'))->links() }}

@endsection
