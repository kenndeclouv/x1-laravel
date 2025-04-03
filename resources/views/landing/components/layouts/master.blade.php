<!doctype html>
<html lang="en" class="layout-navbar-fixed layout-wide" dir="ltr" data-skin="default" data-assets-path="/assets/"
    data-template="front-pages" data-bs-theme="light">

<head>
    <!-- @ 2025 by kenndeclouv https://kenndeclouv.my.id -->
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>@yield('title') | {{ config('app.name') }}</title>
    <!-- SEO -->
    @include('components.partials.seo')
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.svg') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/iconify-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/minecraft.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/akira.css') }}">
    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/pickr/pickr-themes.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/front-page.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/front-page-landing.css') }}" />
    <!-- Page CSS -->
    @yield('page-style')
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
    <script src="{{ asset('assets/js/front-config.js') }}"></script>
</head>

<body class="minecraft-seven-v2">
    @include('landing.components.layouts.sections.navbar')
    @yield('content')
    @include('landing.components.layouts.sections.footer')
    <!-- Core JS -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/pickr/pickr.js') }}"></script>
    <script src="{{ asset('assets/js/front-main.js') }}"></script>
    <!-- Page JS -->
    @yield('page-script')
    @include('components.alert')
</body>

</html>
