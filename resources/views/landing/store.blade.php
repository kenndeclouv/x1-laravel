@extends('landing.components.layouts.master')
@section('title', 'Store')
@section('page-script')
    <script>
        function toggleDescriptionVisibility() {
            const customOptionRadios = document.querySelectorAll('input[name="item"]');
            customOptionRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    customOptionRadios.forEach(r => {
                        const descriptionId = `item-description-${r.id.split('-').pop()}`;
                        const description = document.getElementById(descriptionId);
                        if (description) {
                            if (r.checked) {
                                description.classList.remove('d-none');
                            } else {
                                description.classList.add('d-none');
                            }
                        }
                    });
                });
            });
        }

        function checkout() {
            const item = document.querySelector('input[name="item"]:checked');
            if (item) {
                if (document.querySelector('input[name="user_id"]').value) {
                    window.location.href = "/checkout/" + item.value;
                } else {
                    // window.location.href = "/checkout/" + item.value;
                    window.location.href = "/login?url=/checkout/" + item.value;
                }
            } else {
                alert('Please select an item');
            }
        }

        function updateTabVisibility() {
            const tab = document.querySelector('#tab');
            if (document.documentElement.clientWidth < 996) {
                tab.classList.remove('nav-align-left');
                tab.classList.add('nav-align-top');
            } else {
                tab.classList.remove('nav-align-top');
                tab.classList.add('nav-align-left');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            toggleDescriptionVisibility();
            updateTabVisibility(); // Call the function on page load
        });

        window.addEventListener('resize', updateTabVisibility); // Add event listener for window resize
    </script>
@endsection

@php
    $user = Auth::user() ?? null;
@endphp
@section('content')
    <!-- Sections:Start -->
    <div data-bs-spy="scroll" class="scrollspy-example">
        <input type="hidden" name="user_id" value="{{ $user->id ?? null }}">
        <section
            style="background: linear-gradient(0deg, rgba(0, 0, 0, 0.50) 0%, rgba(0, 0, 0, 0.50) 100%), url({{ asset('assets/img/landing/hero-5.png') }}) lightgray 50% / cover no-repeat; padding-top: 100px;">
            <div class="container py-6 ">
                <div class="card" style="background-color: rgba(var(--bs-body-bg-rgb), 0.6); backdrop-filter: blur(10px);">
                    <div class="card-body p-0 pt-6 position-relative">
                        {{-- <img src="{{ asset('assets/img/landing/MC-About_Key-Art_Survive_the_Night_600x800.png') }}"
                            alt="" class="position-absolute top-0 left-0" style="max-width: 180px; z-index: 1;"> --}}
                        <img src="{{ asset('assets/img/landing/MC-About_Key-Art_Gather_Resources_600x800.png') }}"
                            alt="" class="position-absolute top-25 d-none d-lg-block"
                            style="max-width: 180px; z-index: 1; right: 0%; ">
                        <div class="text-center py-5 z-10">
                            <h1>Unlock Your Minecraft Experience</h1>
                            <p>Explore the exclusive benefits of our community ranks.</p>
                        </div>
                    </div>
                </div>
                <div class="nav-align-left mt-6 pt-6" id="tab">
                    <ul class="nav nav-pills me-md-4" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link waves-effect waves-light active" role="tab"
                                data-bs-toggle="tab" data-bs-target="#rank-tab" aria-controls="rank-tab"
                                aria-selected="true">
                                <i class="icon-base ti tabler-arrow-badge-down me-2"></i> Rank
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link waves-effect waves-light" role="tab"
                                data-bs-toggle="tab" data-bs-target="#money-tab" aria-controls="money-tab"
                                aria-selected="false" tabindex="-1">
                                <i class="icon-base ti tabler-coins me-2"></i> Money
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="{{ route('landing.redeem.index') }}" class="nav-link waves-effect waves-light"
                                tabindex="-1">
                                <i class="icon-base ti tabler-ticket me-2"></i> Redeem Code
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content shadow-none border-0 pt-4 pt-lg-0 px-0 px-lg-6" style="background: transparent">
                        <div class="tab-pane fade active show" id="rank-tab" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="minecraft-ten-v2"> Rank</h2>
                                    <p>
                                        Unlock exclusive benefits and enhance your Minecraft experience with our community
                                        ranks. Explore new features, gain access to premium content, and showcase your
                                        achievements with pride.
                                    </p>
                                </div>
                            </div>
                            <div class="row mt-1 g-3">
                                @if (!$user || $user->item_id == null)
                                    @foreach ($ranks as $rank)
                                        <div class="col-xl-3 col-lg-4 col-md-6 mb-md-0 mb-5">
                                            <div class="form-check custom-option custom-option-icon h-100">
                                                <div class="card h-100"
                                                    style="background-color: rgba(var(--bs-body-bg-rgb), 0.6); backdrop-filter: blur(10px);">
                                                    <div class="card-body p-0">
                                                        <label class="form-check-label custom-option-content"
                                                            for="item-{{ $rank->id }}">
                                                            <span class="custom-option-body text-start">
                                                                <p class="card-text text-end"> <span class="h4"><sup>
                                                                            Rp</sup><strong>
                                                                            {{ $rank->price }}</strong></span> <span
                                                                        class="h6"><sub>/
                                                                            {{ $rank->period }} hari</sub></span></p>
                                                                <div class="text-center">
                                                                    <img src="{{ asset('assets/img/landing/item/' . $rank->id . '.png') }}"
                                                                        alt="" style="width: 100px;">
                                                                </div>
                                                                <span class="custom-option-title minecraft-ten-v2">
                                                                    <h4> {{ $rank->name }}</h4>
                                                                </span>
                                                                <small class="{{ !$loop->first ? 'd-none' : '' }}"
                                                                    id="item-description-{{ $rank->id }}">{{ $rank->description }}</small>
                                                            </span>
                                                            <input name="item" class="form-check-input" type="radio"
                                                                value="{{ $rank->id }}"
                                                                id="item-{{ $rank->id }}"
                                                                @checked($loop->first)>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <a id="checkout-button" onclick="checkout()" class="btn btn-primary btn-lg text-white"><i
                                            class="ti tabler-shopping-cart me-2"></i>
                                        Checkout Now </a>
                                @else
                                    <div class="row mt-6 pt-6 g-6 justify-content-center">
                                        <div class="col-xl-3 col-lg-4 col-md-6 col">
                                            <div class="text-center bg-primary text-white"
                                                style="margin-bottom: -30px; border-radius: 10px 10px 0 0;">
                                                <p class="pb-5">You have an active rank</p>
                                            </div>
                                            <div class="form-check custom-option custom-option-icon h-100">
                                                <div class="card h-100"
                                                    style="background-color: rgba(var(--bs-body-bg-rgb), 0.6); backdrop-filter: blur(10px);">
                                                    <div class="card-body p-0">
                                                        <label class="form-check-label custom-option-content"
                                                            for="item-owned">
                                                            <span class="custom-option-body text-start">
                                                                <p class="card-text text-end"> <span class="h4"><strong>
                                                                            {{ (\Carbon\Carbon::parse($user->item_purchased_at)->diffInDays(\Carbon\Carbon::now()) % 31) + 1 }}
                                                                        </strong></span>
                                                                    <span class="h6"><sub>/
                                                                            {{ $user->item->period }} hari</sub></span>
                                                                </p>
                                                                <div class="text-center">
                                                                    <img src="{{ asset('assets/img/landing/item/' . $user->item->id . '.png') }}"
                                                                        alt="" style="width: 100px;">
                                                                </div>
                                                                <span class="custom-option-title minecraft-ten-v2">
                                                                    <h4> {{ $user->item->name }}</h4>
                                                                </span>
                                                                <small class=""
                                                                    id="item-description-owned">{{ $user->item->description }}</small>
                                                            </span>
                                                            <input name="item" class="form-check-input" type="radio"
                                                                value="{{ $user->item->id }}" id="item-owned" checked>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="tab-pane fade" id="money-tab" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="minecraft-ten-v2"> Money</h2>
                                    <p>
                                        Get instant access to in-game currency and enhance your Minecraft experience with our money packs. Gacha and explore new possibilities.
                                    </p>
                                </div>
                            </div>
                            <div class="row mt-1 g-3">
                                @foreach ($moneys as $money)
                                    <div class="col-xl-3 col-lg-4 col-md-6 mb-md-0 mb-5">
                                        <div class="form-check custom-option custom-option-icon h-100">
                                            <div class="card h-100"
                                                style="background-color: rgba(var(--bs-body-bg-rgb), 0.6); backdrop-filter: blur(10px);">
                                                <div class="card-body p-0">
                                                    <label class="form-check-label custom-option-content"
                                                        for="item-{{ $money->id }}">
                                                        <span class="custom-option-body text-start">
                                                            <p class="card-text text-end"> <span class="h4"><sup>
                                                                        Rp</sup><strong>
                                                                        {{ $money->price }}</strong></span></p>
                                                            <div class="text-center">
                                                                <img src="{{ asset('assets/img/landing/item/' . $money->id . '.png') }}"
                                                                    alt="" style="width: 100px;">
                                                            </div>
                                                            <span class="custom-option-title minecraft-ten-v2">
                                                                <h4> {{ $money->name }}</h4>
                                                            </span>
                                                            <small class="d-none"
                                                                id="item-description-{{ $money->id }}">{{ $money->description }}</small>
                                                        </span>
                                                        <input name="item" class="form-check-input" type="radio"
                                                            value="{{ $money->id }}"
                                                            id="item-{{ $money->id }}">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <a id="checkout-button" onclick="checkout()" class="btn btn-primary btn-lg text-white"><i
                                        class="ti tabler-shopping-cart me-2"></i>
                                    Checkout Now </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
    <!-- / Sections:End -->
@endsection
