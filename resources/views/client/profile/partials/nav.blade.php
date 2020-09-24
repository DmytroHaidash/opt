<div class="flex justify-center -mx-4 mb-6">
    @foreach(['index', 'history', 'favorites'] as $route)
        <a href="{{ route('client.profile.' . $route) }}"
           class="px-4{{ app('router')->is('client.profile.' . $route) ? ' font-bold' : '' }}">
            {{ __('nav.profile.' . $route) }}

            @if (app('router')->is('client.profile.' . $route))
                <div class="border-b-2 mt-2 border-orange-600 w-16 mx-auto"></div>
            @endif
        </a>
    @endforeach
</div>
