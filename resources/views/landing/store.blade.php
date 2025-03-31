@extends('landing.components.layouts.master')
@section('title', 'Home')
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

        document.addEventListener('DOMContentLoaded', toggleDescriptionVisibility);
    </script>

@endsection

@section('content')
    <!-- Sections:Start -->
    <div data-bs-spy="scroll" class="scrollspy-example">
        <section
            style="background: linear-gradient(0deg, rgba(0, 0, 0, 0.50) 0%, rgba(0, 0, 0, 0.50) 100%), url({{ asset('assets/img/landing/wallpaper_minecraft_trickytrials_1920x1080.png') }}) lightgray 50% / cover no-repeat; padding-top: 100px;">
            <div class="container pb-6">
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
                <div class="row mt-6 pt-6 g-6">
                    @foreach ($items as $item)
                        <div class="col-xl-3 col-lg-4 col-md-6 mb-md-0 mb-5">
                            <div class="form-check custom-option custom-option-icon h-100">
                                <div class="card h-100"
                                    style="background-color: rgba(var(--bs-body-bg-rgb), 0.6); backdrop-filter: blur(10px);">
                                    <div class="card-body p-0">
                                        <label class="form-check-label custom-option-content"
                                            for="item-{{ $loop->iteration }}">
                                            <span class="custom-option-body text-start">
                                                <p class="card-text text-end"> <span class="h4"><sup> Rp</sup><strong>
                                                            {{ $item->price }}</strong></span> <span class="h6"><sub>/
                                                            {{ $item->period }} hari</sub></span></p>
                                                <div class="text-center">
                                                    <img src="{{ asset('assets/img/landing/rank/' . $loop->iteration . '.png') }}"
                                                        alt="" style="width: 100px;">
                                                </div>
                                                <span class="custom-option-title minecraft-ten-v2">
                                                    <h4> {{ $item->name }}</h4>
                                                </span>
                                                <small class="{{ !$loop->first ? 'd-none' : '' }}"
                                                    id="item-description-{{ $loop->iteration }}">{{ $item->description }}</small>
                                            </span>
                                            <input name="item" class="form-check-input" type="radio"
                                                value="{{ $item->id }}" id="item-{{ $loop->iteration }}"
                                                @checked($loop->first)>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <button type="submit" class="btn btn-primary btn-lg"><i class="ti tabler-shopping-cart me-2"></i>
                        Checkout Now </button>
                </div>
            </div>
        </section>
    </div>
    <!-- / Sections:End -->
@endsection
