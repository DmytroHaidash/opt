<h1 class="text-3xl font-slab font-bold text-{{ $align }} mb-10{{ $align === 'left' ? ' border-l-4 border-orange-600 pl-4' : '' }}">
    {{ $slot }}

    @if ($align === 'center')
        <div class="border-b-2 mt-2 border-orange-600 w-16 mx-auto"></div>
    @endif
</h1>
