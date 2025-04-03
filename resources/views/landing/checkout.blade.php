@extends('landing.components.layouts.master')
@section('title', 'Store')


@php
    $user = Auth::user();
@endphp
@section('content')
    <!-- Sections:Start -->
    <div data-bs-spy="scroll" class="scrollspy-example">
        <section
            style="background: linear-gradient(0deg, rgba(0, 0, 0, 0.50) 0%, rgba(0, 0, 0, 0.50) 100%), url({{ asset('assets/img/landing/hero-8.png') }}) lightgray 50% / cover no-repeat; padding-top: 100px;">
            <div class="container pb-6">
                <div class="card" style="background-color: rgba(var(--bs-body-bg-rgb), 0.6); backdrop-filter: blur(10px);">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-8 mb-6 mb-xl-0">
                                <ul class="list-group mb-4">
                                    <li class="list-group-item p-6">
                                        <div class="d-flex gap-4">
                                            <div class="flex-shrink-0 d-flex align-items-center">
                                                <img src="{{ asset('assets/img/landing/item/' . $item->id . '.png') }}"
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
                                    <form action="{{ route('landing.checkout.store-transaction', $item->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="is_gift" value="0">
                                        <button type="submit" class="btn btn-primary w-100">Checkout</button>
                                    </form>
                                    <div class="divider">
                                        <div class="divider-text">or</div>
                                    </div>
                                    <button type="button" class="btn btn-info w-100" data-bs-toggle="modal"
                                        data-bs-target="#giftModal">Gift to Another</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="modal fade" id="giftModal" tabindex="-1" aria-labelledby="giftModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="giftModalLabel">Gift to Another</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('landing.checkout.store-transaction', $item->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        {{-- <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="hideName" name="hideName">
                            <label class="form-check-label" for="hideName">Hide your name</label>
                        </div> --}}
                        <input type="hidden" name="is_gift" value="1">
                        <button type="submit" class="btn btn-primary">Send Gift</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
