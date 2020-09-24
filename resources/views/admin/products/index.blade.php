@extends('layouts.admin', ['title' => __('admin.products.title')])

@section('content')

    <div class="flex items-center -mx-6 mb-6">
        <div class="px-6 flex-1">
            <h1 class="font-bold font-slab text-3xl">{{ __('admin.products.title') }}</h1>
        </div>

        <div class="px-6">
            <a href="{{ route('admin.products.create') }}" class="button button--primary button--sm">
                {{ __('admin.products.create') }}
            </a>
        </div>
    </div>

    <table class="w-full">
        <x-table-header/>

        @forelse($products as $product)
            <tr>
                <td class="p-3">{{ $product->id }}</td>
                <td class="p-3 w-3/4">
                    @if ($product->hasMedia())
                    <img src="{{ $product->thumb }}" class="w-12 h-12 rounded inline-flex mr-3">
                    @endif
                    <span class="font-bold text-lg">{{ $product->title }}</span>
                </td>
                <td class="p-3 w-1/4">{{ $product->user->name }}</td>
                <td class="p-3 whitespace-no-wrap">{{ $product->created_at->format('d.m.Y H:i') }}</td>
                <td class="p-3">{{ $product->views_count }}</td>
                <td class="p-3 whitespace-no-wrap">
                    @if($product->is_published)
                        {{ __('admin.products.statuses.published') }}
                    @elseif($product->published_requested_at)
                        {{ __('admin.products.statuses.moderated') }}
                    @else
                        {{ __('admin.products.statuses.not_published') }}
                    @endif
                </td>
                <td class="p-3 w-8">
                    <x-table-actions
                        :edit="route('admin.products.edit', $product)"
                        :delete="route('admin.products.destroy', $product)"
                    />
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="p-3 text-center">{{ __('admin.not_found') }}</td>
            </tr>
        @endforelse
    </table>

    {{ $products->appends(request()->except('page'))->links() }}

    @includeIf('partials.admin.deletions')

@endsection
