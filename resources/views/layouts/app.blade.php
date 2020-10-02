<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="locales" content="{{ implode(',', config('translatable.locales')) }}">
    @includeIf('partials.favicons')

    <title>{{ (isset($title) ? $title . ' | ' : '') . config('app.name') }}</title>

    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://js.api.here.com">

    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,600,700&display=swap" rel="stylesheet">

    <link rel="preload" href="{{ asset('css/client.css') }}" as="style" />
    <link rel="prefetch" href="{{ asset('css/admin.css') }}" as="style" />

    <link rel="preload" href="{{ asset('js/client.js') }}" as="script" />
    <link rel="preload" href="{{ asset('js/i18n.js') }}" as="script" />
    <link rel="prefetch" href="{{ asset('js/admin.js') }}" as="script" />

    <link rel="prefetch" href="https://js.api.here.com/v3/3.1/mapsjs-core.js" as="script" />
    <link rel="prefetch" href="https://js.api.here.com/v3/3.1/mapsjs-service.js" as="script" />
    <link rel="prefetch" href="https://js.api.here.com/v3/3.1/mapsjs-ui.js" as="script" />
    <link rel="prefetch" href="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js" as="script" />

    <link href="{{ asset('css/client.css') }}" rel="stylesheet">
    <meta property="og:site_name" content="{{config('app.name')}}">
    @if(request()->route()->getName() != 'client.products.show' && request()->route()->getName() != 'client.carriers.show')
    <meta property="og:image" content="{{ asset('images/icons/apple-touch-icon.png') }}" />
    @endif
    @yield('meta')
    @stack('styles')
</head>
<body class="text-gray-800 antialiased">
<div id="root" class="flex flex-col min-h-screen">
    @includeIf('partials.client.layout.header')

    <main class="flex-1">
        @yield('content')
    </main>

    @includeIf('partials.client.layout.footer')
    @includeIf('partials.client.layout.notifications')
</div>

<script src="{{ asset('js/i18n.js') }}"></script>
<script src="{{ asset('js/client.js') }}"></script>
@stack('scripts')
</body>
</html>
