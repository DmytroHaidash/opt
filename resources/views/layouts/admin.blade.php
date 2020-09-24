<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="locales" content="{{ implode(',', config('translatable.locales')) }}">
    @includeIf('partials.favicons')

    <title>{{ (isset($title) ? $title . ' | ' : '') . config('app.name') }}</title>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,600,700&display=swap" rel="stylesheet">

    <link rel="preload" href="{{ asset('css/admin.css') }}" as="style" />
    <link rel="preload" href="{{ asset('js/admin.js') }}" as="script" />

    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body class="text-gray-800 antialiased">
<div id="root" class="">
    @includeIf('partials.admin.aside')
    <div class="ml-56">
        @includeIf('partials.admin.header')

        <main class="m-6">
            @includeIf('partials.admin.notifications')
            @yield('content')
        </main>

        @includeIf('partials.admin.footer')
    </div>
</div>

<script src="{{ asset('js/i18n.js') }}" defer></script>
<script src="{{ asset('js/admin.js') }}" defer></script>
@stack('scripts')
</body>
</html>
