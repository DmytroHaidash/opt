@extends('layouts.app', ['title' => __('admin.products.title')])

@section('content')

    <section class="container my-6 lg:my-12">
        <div class="flex items-center -mx-6 mb-6">
            <div class="px-6 flex-1">
                <h1 class="font-bold font-slab text-3xl">{{ __('admin.products.title') }}</h1>
            </div>
            @if(Auth::user()->email_verified_at != null && Auth::user()->ads_in_day < app('settings')->ads_per_day)
                <div class="px-6">
                    <a href="{{ route('client.profile.products.create') }}" class="button button--primary button--sm">
                        {{ __('admin.products.create') }}
                    </a>
                </div>
            @endif
        </div>
        @if(Auth::user()->email_verified_at == null)
            <div class="mb-3 flex justify-center">
                <a href="{{route('verification.notice')}}"
                   class="border-b border-red-500 hover:border-red-700 transition duration-300 text-2xl">
                    {{ __('shop.rules.verify_email') }}</a>
            </div>
        @elseif(Auth::user()->ads_in_day >= app('settings')->ads_per_day)
            <div class="mb-3 flex justify-center">
                <p class="border-b border-red-500 hover:border-red-700 transition duration-300 text-2xl">
                    {{ __('shop.rules.max_ads') }}
                </p>
            </div>
        @endif

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
                        <div class="inline-flex ml-4">
                            @if($product->is_published)
                                {{ __('admin.products.statuses.published') }}
                            @elseif($product->published_requested_at)
                                {{ __('admin.products.statuses.moderated') }}
                            @else
                                {{ __('admin.products.statuses.not_published') }}
                            @endif
                        </div>
                    </td>
                    <td class="p-3 whitespace-no-wrap">{{ $product->created_at->format('d.m.Y H:i') }}</td>
                    <td class="p-3">{{ $product->views_count }}</td>
                    <td class="p-3 w-8">
                        <x-table-actions
                            :edit="route('client.profile.products.edit', $product)"
                            :delete="route('client.profile.products.destroy', $product)"
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
    </section>

@endsection
