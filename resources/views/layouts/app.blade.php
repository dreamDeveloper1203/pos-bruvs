<!DOCTYPE html>
<html lang="en" dir="ltr" translate="yes">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>@yield('title', config('app.name'))</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-TileImage" content="/mstile-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link rel="preload" href="{{ mix('css/app.css') }}" as="style" />
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    @stack('style')
    @stack('head')
</head>

<body>
    <div id="app">
        @auth
            @include('layouts.navbar')
            @include('layouts.sidebar-items')
            <div class="container-fluid py-3">
                @include('layouts.alerts')
                @yield('content')
            </div>
        @else
            <div class="">
                @yield('content')
            </div>
        @endauth
    </div>
</body>

</html>
<script src="{{ mix('js/app.js') }}"></script>
@stack('script')
