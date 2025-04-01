@extends('landing.components.layouts.master')
@section('title', 'Store')


@php
    $user = Auth::user();
@endphp
@section('content')
    <!-- Sections:Start -->
    <div data-bs-spy="scroll" class="scrollspy-example">
        <section
            style="background: linear-gradient(0deg, rgba(0, 0, 0, 0.50) 0%, rgba(0, 0, 0, 0.50) 100%), url({{ asset('assets/img/landing/wallpaper_minecraft_trickytrials_1920x1080.png') }}) lightgray 50% / cover no-repeat; padding-top: 100px;">
            <div class="container pb-6">
                <div class="card" style="background-color: rgba(var(--bs-body-bg-rgb), 0.6); backdrop-filter: blur(10px);">
                    <div class="card-body">
                        <div class="row">
                            <!-- Cart left -->
                            <div class="col-xl-8 mb-6 mb-xl-0">
                                <!-- Offer alert -->
                                {{-- <div class="alert alert-success mb-4" role="alert">
                                    <div class="d-flex gap-4">
                                        <div class="alert-icon flex-shrink-0 rounded me-0">
                                            <i class="ti ti-percentage"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h5 class="alert-heading mb-1">Available Offers</h5>
                                            <ul class="list-unstyled mb-0">
                                                <li> - 10% Instant Discount on Bank of America Corp Bank Debit
                                                    and
                                                    Credit cards</li>
                                                <li> - 25% Cashback Voucher of up to $60 on first ever PayPal
                                                    transaction. TCA</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-close btn-pinned" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div> --}}

                                <!-- Shopping bag -->
                                {{-- <h5>My Shopping Bag (2 Items)</h5> --}}
                                <ul class="list-group mb-4">
                                    <li class="list-group-item p-6">
                                        <div class="d-flex gap-4">
                                            <div class="flex-shrink-0 d-flex align-items-center">
                                                <img src="{{ asset('assets/img/landing/rank/' . $item->id . '.png') }}"
                                                    alt="{{ $item->name }}" class="w-px-100">
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <p class="me-3 mb-2"><span
                                                                class="text-heading h4">{{ strtoupper($item->name) }}</span>
                                                        </p>
                                                        <div class="text-muted mb-2 d-flex flex-wrap"><span
                                                                class="me-1">{{ $item->description }}</span>
                                                        </div>

                                                        {{-- <input type="number" class="form-control form-control-sm w-px-100" value="1" min="1" max="5"> --}}
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="text-md-end">
                                                            <div class="my-2 mt-md-6 mb-md-4"><span class="text-primary">Rp.
                                                                    {{ number_format($item->price, 0, ',', '.') }}</span>
                                                            </div>
                                                            {{-- <button type="button" class="btn btn-sm btn-label-primary waves-effect">Move to wishlist</button> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>

                            </div>

                            <!-- Cart right -->
                            <div class="col-xl-4">
                                <div class="border rounded p-6 mb-4">
                                    <dl class="row mb-0">
                                        <dt class="col-6 text-heading">Total</dt>
                                        <dd class="col-6 fw-medium text-end text-heading mb-0">Rp.
                                            {{ number_format($item->price, 0, ',', '.') }}</dd>
                                    </dl>
                                </div>
                                <div class="d-grid">
                                    <form action="{{ route('landing.checkout.store', $item->id) }}" method="post">
                                        @csrf
                                        <button class="btn btn-primary w-100">Checkout</button>
                                    </form>
                                    <div class="divider">
                                        <div class="divider-text">or</div>
                                    </div>
                                    <form action="{{ route('landing.checkout.gift', $item->id) }}" method="post">
                                        @csrf
                                        <button class="btn btn-info w-100">Gift to Another</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
