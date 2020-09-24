<form action="{{ route('locale') }}" method="post">
    @csrf

    @foreach(config('translatable.locales') as $locale)
        @if (app()->getLocale() !== $locale)
            <input type="submit" id="locale" value="{{ $locale }}" name="locale" class="absolute invisible">
            <label for="locale" class="cursor-pointer">{{ strtoupper($locale) }}</label>
        @else
            <span class="font-bold">{{ strtoupper($locale) }}</span>
        @endif

        @if (!$loop->last)
            <span class="text-gray-500">|</span>
        @endif
    @endforeach
</form>
