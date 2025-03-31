@extends('landing.components.layouts.master')
@section('title', 'Home')
@section('page-script')
    <script>
        const memberCount = document.getElementById('member-count');
        const memberCountWrapper = document.getElementById('member-count-wrapper');
        fetch('/api/discord-members')
            .then(response => response.json())
            .then(data => {
                memberCount.textContent = data.online_members.toString() + "/" + data.total_members.toString();
            }).catch(error => {
                memberCountWrapper.textContent = 'Error fetching member count';
                memberCountWrapper.classList = 'text-danger';
            });
    </script>
@endsection

@section('content')
    <!-- Sections:Start -->
    <div data-bs-spy="scroll" class="scrollspy-example">
        <section
            style="background: linear-gradient(0deg, rgba(0, 0, 0, 0.50) 0%, rgba(0, 0, 0, 0.50) 100%), url({{ asset('assets/img/landing/wallpaper_minecraft_trickytrials_1920x1080.png') }}) lightgray 50% / cover no-repeat;">
            <div class="container ">
                <div class="d-flex flex-column vh-100">
                    <div class="my-auto">
                        <h1 class="text-white akira" style="font-size: 3rem;">Community with</h1>
                        <h2 class="text-white akira" style="font-size: 2rem;">a lot of fun :)</h2>
                        <p class="text-success minecraft-seven-v2" style="font-size: 1.5rem;" id="member-count-wrapper">
                            <span id="member-count">0/0</span> Online Members <span
                                class="badge badge-center rounded-pill bg-success my-auto"
                                style="width: 15px; height: 15px; display: inline-block;"></span></p>
                        <div class="btn btn-primary btn-lg"><i class="icon-base ti tabler-login scaleX-n1-rtl me-md-1"></i>
                            Join Now</div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- / Sections:End -->
@endsection
