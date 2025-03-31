<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="layout-navbar-fixed layout-menu-fixed layout-compact"
    dir="ltr" data-skin="default" data-assets-path="/assets/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>@yield('title') | {{ config('app.name') }}</title>

    @include('components.layouts.sections.head')
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/minecraft.css') }}">
</head>

<body>
    <div class="layout-wrapper layout-content-navbar minecraft-seven-v2">
        <div class="layout-container">
            <!-- SIDEBAR -->
            @include('components.layouts.sections.sidebar')
            <div class="menu-mobile-toggler d-xl-none rounded-1">
                <a href="javascript:void(0);"
                    class="layout-menu-toggle menu-link text-large text-bg-secondary p-2 rounded-1">
                    <i class="ti tabler-menu icon-base"></i>
                    <i class="ti tabler-chevron-right icon-base"></i>
                </a>
            </div>
            <!-- / SIDEBAR -->

            <!-- CONTAINER -->
            <div class="layout-page">
                <!-- Navbar -->
                @include('components.layouts.sections.nav')
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- CONTENT -->
                    @yield('content')

                    <!-- / CONTENT -->

                    <!-- FOOTER -->
                    @include('components.layouts.sections.footer')
                    <!-- /FOOTER -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- SCRIPTS -->
    @include('components.partials.scripts')
    @include('components.alert')
</body>

</html>
