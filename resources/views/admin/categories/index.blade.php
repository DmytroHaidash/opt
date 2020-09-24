@extends('layouts.admin', ['title' => __('admin.categories.title')])

@section('content')

    <div class="flex items-center -mx-6 mb-6">
        <div class="px-6 flex-1">
            <h1 class="font-bold font-slab text-3xl">{{ __('admin.categories.title') }}</h1>
        </div>

        <div class="px-6">
            <a href="{{ route('admin.categories.create', ['taxonomy' => request('taxonomy')]) }}"
               class="button button--primary button--sm">
                {{ __('admin.categories.create') }}
            </a>
        </div>
    </div>

    <table class="w-full">
        <x-table-header/>

        @forelse($categories as $category)
            <tr>
                <td class="p-3">{{ $category->id }}</td>
                <td class="p-3 w-full">{{ $category->title }}</td>
                <td class="p-3">{{ optional($category->parent)->title ?? '---' }}</td>
                <td class="p-3 w-8">
                    <x-table-actions
                        :edit="route('admin.categories.edit', [$category, 'taxonomy' => $category->taxonomy])"
                        :delete="route('admin.categories.destroy', $category)"
                    />
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="p-3 text-center">{{ __('admin.not_found') }}</td>
            </tr>
        @endforelse
    </table>

    {{ $categories->appends(request()->except('page'))->links() }}

    @includeIf('partials.admin.deletions')

@endsection
