<section class="py-12 bg-gray-50">
    <div class="container">
        <x-section-title :route="route('client.news.index')">{{ __('Новости') }}</x-section-title>

        <div class="flex flex-wrap -m-4">
            @each('partials.client.news.article', $articles, 'article')
        </div>
    </div>
</section>
