<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="layout-navbar-fixed layout-menu-fixed layout-compact"
    dir="ltr" data-skin="default" data-assets-path="/assets/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>@yield('title') | {{ config('app.name') }}</title>
    @include('components.layouts.sections.head')
</head>

<body>
    <div class="layout-wrapper layout-content-navbar minecraft-seven-v2">
        <div class="layout-container">
            @include('components.layouts.sections.sidebar')
            <div class="layout-page">
                @include('components.layouts.sections.nav')
                {{-- <x-layouts.sections.nav></x-layouts.sections.nav> --}}
                <div class="content-wrapper">
                    @yield('content')
                    @include('components.layouts.sections.footer')
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
        <div class="drag-target"></div>
    </div>
    @include('components.partials.scripts')
    @include('components.alert')
</body>

</html>
