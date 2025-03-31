<!-- Footer: Start -->
<footer class="landing-footer footer-text"
    style="background: top linear-gradient(0deg, rgba(0, 0, 0, 0.70) 0%, rgba(0, 0, 0, 1) 100%), url({{ asset('assets/img/landing/b24bb22c50be84cb9a35e82eece0f5d9.jpg') }}) lightgray 50% / cover no-repeat; padding-top:100px">
    <div class="footer-top position-relative overflow-hidden z-1">
        {{-- <img src="{{ asset('assets/img/landing/footerbg.png') }}" alt="footer bg"
                class=" z-n1 w-100" /> --}}
        <div class="container">
            <div class="row gx-0 gy-6 g-lg-10">
                <div class="col-lg-5">
                    <a href="landing-page.html" class="app-brand-link mb-6">
                        <img src="{{ asset('assets/img/landing/x1-light.png') }}" alt="" style="width: 40px;">
                    </a>
                    <p class="footer-text footer-logo-description mb-6">
                        Community with a lot of fun :)
                    </p>
                    <form class="footer-form">
                        <p>X1 Community is a place where you can have fun and connect with others. Join us now and
                            be a part of our community!</p>
                    </form>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <h6 class="footer-title mb-6">Links</h6>
                    <ul class="list-unstyled">
                        <li class="mb-4">
                            <a class="footer-link {{ request()->is('/') ? 'minecraft-ten-v2' : '' }}"
                                aria-current="page"
                                href="{{ request()->is('/') ? '#' : route('landing.index') }}">Home</a>
                        </li>
                        <li class="mb-4">
                            <a class="footer-link {{ request()->is('rules') ? 'minecraft-ten-v2' : '' }}"
                                href="{{ request()->is('rules') ? '#' : route('landing.rules') }}">Rules</a>
                        </li>
                        <li class="mb-4">
                            <a class="footer-link {{ request()->is('store') ? 'minecraft-ten-v2' : '' }}"
                                href="{{ request()->is('store') ? '#' : route('landing.store') }}">Store</a>
                        </li>
                        <li class="mb-4">
                            <a class="footer-link {{ request()->is('staff') ? 'minecraft-ten-v2' : '' }}"
                                href="{{ request()->is('staff') ? '#' : route('landing.staff') }}">Staff</a>
                        </li>
                        <li class="mb-4">
                            <a class="footer-link" href="https://discord.gg/3gvZdYM2ek" target="_blank"> Discord</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <h6 class="footer-title mb-6">Social</h6>
                    <ul class="list-unstyled">
                        <li class="mb-4">
                            <a href="https://www.facebook.com/x1community" target="_blank"
                                class="footer-link">Facebook</a>
                        </li>
                        <li class="mb-4">
                            <a href="https://twitter.com/x1community" target="_blank" class="footer-link">Twitter</a>
                        </li>
                        <li class="mb-4">
                            <a href="https://www.instagram.com/x1community/" target="_blank"
                                class="footer-link">Instagram</a>
                        </li>
                        <li class="mb-4">
                            <a href="https://www.youtube.com/x1community" target="_blank"
                                class="footer-link">YouTube</a>
                        </li>
                        <li class="mb-4">
                            <a href="https://discord.gg/x1community" target="_blank" class="footer-link">Discord</a>
                        </li>
                    </ul>
                </div>
            </div>
            <img src="{{ asset('assets/img/landing/footer.png') }}" alt="" class="w-100 my-5">
        </div>
    </div>
    {{-- <div class="footer-bottom py-3 py-md-5">
        </div> --}}
</footer>
<!-- Footer: End -->
