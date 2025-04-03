@extends('landing.components.layouts.master')
@section('title', 'Home')
@section('page-script')
    <script>
        const memberCount = document.getElementById('member-count');
        const memberCountWrapper = document.getElementById('member-count-wrapper');
        fetch('/api/minecraft-server')
            .then(response => response.json())
            .then(data => {
                memberCount.textContent = data.players.online + "/" + data.players.max;
            }).catch(error => {
                memberCountWrapper.textContent = 'Error fetching member count';
                memberCountWrapper.classList.add('text-danger');
                console.error(error);
            });
    </script>
@endsection

@section('content')
    <!-- Sections:Start -->
    <div data-bs-spy="scroll" class="scrollspy-example">
        <section
            style="background: linear-gradient(0deg, rgba(0, 0, 0, 0.50) 0%, rgba(0, 0, 0, 0.50) 100%), url({{ asset('assets/img/landing/hero-1.png') }}) lightgray 50% / cover no-repeat;">
            <div class="container ">
                <div class="d-flex flex-column vh-100">
                    <div class="my-auto">
                        <h1 class="text-white minecraft-ten-v2 m-0" style="line-height: 0.95">Welcome, enjoy your time here</h1>
                        <h2 class="text-white minecraft-ten-v2 opacity-75">and let’s play together!</h2>
                        <p class="text-success" style="font-size: 1.5rem;" id="member-count-wrapper">
                            <span id="member-count">0/0</span> Online Members <span
                                class="badge badge-center rounded-pill bg-success my-auto"
                                style="width: 15px; height: 15px; display: inline-block;"></span></p>
                        <div class="btn btn-primary btn-lg"><i class="icon-base ti tabler-login scaleX-n1-rtl me-md-1"></i>
                            Join Now</div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <img src="{{ asset('assets/img/landing/home-second-banner.png') }}" alt="" class="w-100 h-100">
        </section>
    </div>
    <!-- / Sections:End -->
@endsection
