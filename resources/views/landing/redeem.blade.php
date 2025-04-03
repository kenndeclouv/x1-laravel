@extends('landing.components.layouts.master')
@section('title', 'Redeem Your Code')

@section('page-script')
    <script>
        function format(input) {
            let value = input.value.replace(/[^a-zA-Z0-9]/g, ''); // hanya huruf & angka
            let formatted = value.match(/.{1,5}/g)?.join('-') ?? value; // setiap 5 karakter dikasih "-"
            input.value = formatted.slice(0, 29); // batasin ke 29 karakter (5 blok + 4 dash)
        }
    </script>
@endsection

@section('content')
    <!-- Sections:Start -->
    <div data-bs-spy="scroll" class="scrollspy-example">
        <section id="staff-section"
            style="background: linear-gradient(0deg, rgba(0, 0, 0, 0.50) 0%, rgba(0, 0, 0, 0.50) 100%), url({{ asset('assets/img/landing/hero-10.png') }}) lightgray 50% / cover no-repeat; padding-top: 100px;">
            <div class="container pb-6">
                <div class="card" style="background-color: rgba(var(--bs-body-bg-rgb), 0.6); backdrop-filter: blur(10px);">
                    <div class="card-body p-0 pt-6 position-relative">
                        <img src="{{ asset('assets/img/landing/redeem-hero.png') }}"
                            alt="" class="position-absolute top-0 left-0 d-none d-lg-block" style="max-width: 180px; margin-bottom: -10px;">
                        <div class="text-center py-5 position-relative z-10">
                            <h1>Redeem Your Code</h1>
                            <p>Enter your unique code to unlock exclusive rewards.</p>
                        </div>
                    </div>
                </div>
                <form action="{{ route('landing.redeem.redeem') }}" method="POST">
                    @csrf
                    <div class="card mt-6"
                        style="background-color: rgba(var(--bs-body-bg-rgb), 0.6); backdrop-filter: blur(10px);">
                        <div class="card-body d-flex justify-content-center">
                            <div class="input-group input-group-lg" style="max-width: 450px;">
                                <input type="text" class="form-control" id="redeem" name="token"
                                    placeholder="XXXXX-XXXXX-XXXXX-XXXXX-XXXXX" autocomplete="false" maxlength="29" oninput="format(this)">
                                <button class="btn btn-outline-primary waves-effect" type="submit"
                                    id="redeem-button">Redeem</button>
                            </div>
                        </div>
                    </div>
                </form>
                <a href="{{ route('landing.store') }}" class="btn btn-primary mt-3"><i class="icon-base ti tabler-arrow-left me-2"></i> Back</a>
            </div>
        </section>
    </div>
    <!-- / Sections:End -->
@endsection
