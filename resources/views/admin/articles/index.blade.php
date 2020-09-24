@extends('layouts.admin', ['title' => __('admin.articles.title')])

@section('content')

    <div class="flex items-center -mx-6 mb-6">
        <div class="px-6 flex-1">
            <h1 class="font-bold font-slab text-3xl">{{ __('admin.articles.title') }}</h1>
        </div>

        <div class="px-6">
            <a href="{{ route('admin.articles.create') }}" class="button button--primary button--sm">
                {{ __('admin.articles.create') }}
            </a>
        </div>
    </div>

    <table class="w-full">
        <x-table-header/>

        @forelse($articles as $article)
            <tr>
                <td class="p-3">{{ $article->id }}</td>
                <td class="p-3 w-full">{{ $article->title }}</td>
                <td class="p-3 whitespace-no-wrap">{{ optional($article->published_at)->format('d.m.Y H:i') ?? '---' }}</td>
                <td class="p-3 w-8">
                    <x-table-actions
                        :edit="route('admin.articles.edit', $article)"
                        :delete="route('admin.articles.destroy', $article)"
                    />
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="p-3 text-center">{{ __('admin.not_found') }}</td>
            </tr>
        @endforelse
    </table>

    {{ $articles->appends(request()->except('page'))->links() }}

    @includeIf('partials.admin.deletions')

@endsection
