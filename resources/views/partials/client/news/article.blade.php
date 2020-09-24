<article class="p-4 w-full lg:w-1/3">
    <a href="{{ route('client.news.show', $article->getPath()) }}">
        <p class="text-xs text-gray-600">
            <span class="bg-gray-800 text-white px-2 py-1 rounded">{{ __('Новости') }}</span>
            <span class="font-bold ml-2">{{ $article->published_at->format('d.m.Y') }}</span>
        </p>
        <h2 class="text-lg font-bold my-2">{{ $article->title }}</h2>
        @if($article->description)
            <p class="text-sm text-gray-700">{{ Str::limit($article->description, 100) }}</p>
        @endif
    </a>
</article>
