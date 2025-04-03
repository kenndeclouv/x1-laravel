@extends('landing.components.layouts.master')
@section('title', 'Our Awesome Staff')

@section('content')
    <!-- Sections:Start -->
    <div data-bs-spy="scroll" class="scrollspy-example">
        <section id="staff-section"
            style="background: linear-gradient(0deg, rgba(0, 0, 0, 0.50) 0%, rgba(0, 0, 0, 0.50) 100%), url({{ asset('assets/img/landing/hero-3.png') }}) lightgray 50% / cover no-repeat; padding-top: 100px;">
            <div class="container pb-6">
                <div class="card" style="background-color: rgba(var(--bs-body-bg-rgb), 0.6); backdrop-filter: blur(10px);">
                    <div class="card-body p-0 pt-6 position-relative">
                        <img src="{{ asset('assets/img/landing/staff-hero.png') }}"
                            alt="" class="position-absolute top-0 right-0" style="max-width: 290px;">
                        {{-- <img src="{{ asset('assets/img/landing/MC-About_Key-Art_Gather_Resources_600x800.png') }}"
                            alt="" class="position-absolute bottom-0 right-0" style="max-width: 180px; z-index: 1;"> --}}
                        <div class="text-center py-5 position-relative z-10">
                            <h1>Our Awesome Staff</h1>
                            <p>Meet the talented individuals behind our community.</p>
                        </div>
                    </div>
                </div>
                <div class="row g-6 mt-6">
                    @foreach ($staffs as $staff)
                        <div class="col-sm-6 col-lg-4">
                            <div class="card p-2 pt-5 h-100 shadow-none border"
                                style="background-color: rgba(var(--bs-body-bg-rgb), 0.6); backdrop-filter: blur(10px);">
                                <div class="rounded-2 text-center mb-4">
                                    <img class="img-fluid rounded-2"
                                        src="{{ asset('assets/img/landing/staff/' . $staff->photo) }}"
                                        alt="{{ $staff->name }}" style="width: clamp(128px, 100%, 256px);">
                                </div>
                                <div class="card-body pt-2 pb-0 text-center">
                                    <span class="badge bg-label-primary">{{ $staff->role }}</span>
                                    <br>
                                    <a href="{{ $staff->link ?? '#' }}" target="_blank" class="h2 minecraft-ten-v2">{{ $staff->name }}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
    <!-- / Sections:End -->
@endsection
