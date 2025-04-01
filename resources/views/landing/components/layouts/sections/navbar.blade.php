<!-- Navbar: Start -->
<nav class="layout-navbar shadow-none py-0">
    <div class="container">
        <div class="navbar navbar-expand-lg landing-navbar px-3 px-md-8">
            <!-- Menu logo wrapper: Start -->
            <div class="navbar-brand app-brand demo d-flex py-0 me-4 me-xl-8 ms-0">
                <!-- Mobile menu toggle: Start-->
                <button class="navbar-toggler border-0 px-0 me-4" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <i class="icon-base ti tabler-menu-2 icon-lg align-middle text-heading fw-medium"></i>
                </button>
                <!-- Mobile menu toggle: End-->
                <a href="landing-page.html" class="app-brand-link">
                    <svg width="35" height="39" viewBox="0 0 35 39" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M30.2856 0.81323L16.7262 14.6689C16.6584 14.7382 16.5475 14.7388 16.4789 14.6703L11.9667 10.1605C11.8867 10.0806 11.9021 9.94639 11.9982 9.88685L12.9981 9.26688C13.1477 9.1741 13.0823 8.9422 12.9065 8.9422H0.877187C0.721446 8.9422 0.643764 9.1318 0.754318 9.2421L11.3708 19.8336C11.4397 19.9023 11.4395 20.0144 11.3704 20.0829L2.78824 28.5994C2.75503 28.6323 2.73633 28.6773 2.73633 28.7242V38.5847C2.73633 38.7409 2.92397 38.8192 3.03394 38.709L30.5331 11.1452C30.5659 11.1123 30.5843 11.0676 30.5843 11.021V0.936246C30.5843 0.7793 30.395 0.701358 30.2856 0.81323Z"
                            fill="var(--bs-heading-color)" />
                        <path
                            d="M18.1939 26.0786L23.0274 21.2189C23.0958 21.1501 23.2068 21.1504 23.2748 21.2196L32.559 30.6641C32.6679 30.7749 32.5898 30.9628 32.4349 30.9628H20.3413C20.1732 30.9628 20.1024 30.7472 20.2374 30.6465L21.3082 29.8483C21.3929 29.7852 21.403 29.6616 21.3297 29.5855L18.1919 26.3246C18.1257 26.2558 18.1266 26.1463 18.1939 26.0786Z"
                            fill="var(--bs-heading-color)" />
                        <path
                            d="M34.528 36.0693L27.694 36.0694C27.598 36.0694 27.52 35.9913 27.5196 35.8948L27.5051 32.7606H32.4349C34.1778 32.7606 35.0559 30.6466 33.8307 29.4003L27.4597 22.9193L27.4407 18.7972C27.4402 18.6904 27.3457 18.6088 27.2406 18.6245L25.9245 18.821C25.7582 18.8459 25.6566 18.6431 25.7755 18.5235L34.3258 9.92658C34.4355 9.81627 34.6232 9.89407 34.6236 10.0501L34.7024 35.8934C34.7027 35.9905 34.6245 36.0693 34.528 36.0693Z"
                            fill="var(--bs-heading-color)" />
                    </svg>
                    {{-- <span class="app-brand-text demo menu-text fw-bold">Community</span> --}}
                    {{-- <img src="{{ asset('assets/img/landing/x1-dark.png') }}" height="30" alt=""> --}}
                </a>
            </div>
            <!-- Menu logo wrapper: End -->
            <!-- Menu wrapper: Start -->
            <div class="collapse navbar-collapse landing-nav-menu" id="navbarSupportedContent">
                <button class="navbar-toggler border-0 text-heading position-absolute end-0 top-0 scaleX-n1-rtl p-2"
                    type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="icon-base ti tabler-x icon-lg"></i>
                </button>
                <ul class="navbar-nav me-auto minecraft-seven-v2">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'minecraft-ten-v2' : '' }}" aria-current="page"
                            href="{{ request()->is('/') ? '#' : route('landing.index') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('rules') ? 'minecraft-ten-v2' : '' }}"
                            href="{{ request()->is('rules') ? '#' : route('landing.rules') }}">Rules</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('store') || request()->is('checkout/*') ? 'minecraft-ten-v2' : '' }}"
                            href="{{ request()->is('store') ? '#' : route('landing.store') }}">Store</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('staff') ? 'minecraft-ten-v2' : '' }}"
                            href="{{ request()->is('staff') ? '#' : route('landing.staff') }}">Staff</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://discord.gg/3gvZdYM2ek" target="_blank"> Discord</a>
                    </li>
                </ul>
            </div>
            <div class="landing-menu-overlay d-lg-none"></div>
            <!-- Menu wrapper: End -->
            <!-- Toolbar: Start -->
            <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Style Switcher -->
                <li class="nav-item dropdown-style-switcher dropdown me-2 me-xl-1">
                    <a class="nav-link dropdown-toggle hide-arrow" id="nav-theme" href="javascript:void(0);"
                        data-bs-toggle="dropdown">
                        <i class="icon-base ti tabler-sun icon-lg theme-icon-active"></i>
                        <span class="d-none ms-2" id="nav-theme-text">Toggle theme</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="nav-theme-text">
                        <li>
                            <button type="button" class="dropdown-item align-items-center active"
                                data-bs-theme-value="light" aria-pressed="false">
                                <span><i class="icon-base ti tabler-sun icon-md me-3" data-icon="sun"></i>Light</span>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="dropdown-item align-items-center" data-bs-theme-value="dark"
                                aria-pressed="true">
                                <span><i class="icon-base ti tabler-moon-stars icon-md me-3"
                                        data-icon="moon-stars"></i>Dark</span>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="dropdown-item align-items-center" data-bs-theme-value="system"
                                aria-pressed="false">
                                <span><i class="icon-base ti tabler-device-desktop-analytics icon-md me-3"
                                        data-icon="device-desktop-analytics"></i>System</span>
                            </button>
                        </li>
                    </ul>
                </li>
                <!-- / Style Switcher-->

                <!-- navbar button: Start -->
                <li>
                    @if (!Auth::check())
                        <a href="{{ route('login') }}" class="btn btn-primary" target="_blank"><span
                                class="tf-icons icon-base ti tabler-login scaleX-n1-rtl me-md-1"></span><span
                                class="d-none d-md-block">Login/Register</span></a>
                    @else
                        <a href="{{ route('home') }}" class="btn btn-primary" target="_blank"><span
                                class="tf-icons icon-base ti tabler-home scaleX-n1-rtl me-md-1"></span><span
                                class="d-none d-md-block">Dashboard</span></a>
                    @endif
                </li>
                <!-- navbar button: End -->
            </ul>
            <!-- Toolbar: End -->
        </div>
    </div>
</nav>
<!-- Navbar: End -->
