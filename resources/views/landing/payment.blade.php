@extends('landing.components.layouts.master')
@section('title', 'Store')

@section('page-script')
    <!-- TODO: Remove ".sandbox" from script src URL for production environment. Also input your client key in "data-client-key" -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.clientKey') }}">
    </script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            fetch('{{ route('landing.checkout.snap-token', $transaction->id) }}')
                .then(response => response.json())
                .then(data => {
                    snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            window.location.href =
                                '{{ route('landing.checkout.payment-success', $transaction->id) }}';
                        },
                        onPending: function(result) {
                            Swal.fire({
                                title: 'Transaction Pending',
                                text: JSON.stringify(result, null, 2),
                                icon: 'info',
                                confirmButtonText: 'OK'
                            });
                        },
                        onError: function(result) {
                            Swal.fire({
                                title: 'Transaction Error',
                                text: JSON.stringify(result, null, 2),
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                })
                .catch(error => console.error('Error fetching snap token:', error));
        };
    </script>
@endsection

@php
    $user = Auth::user();
@endphp
@section('content')
    <!-- Sections:Start -->
    <div data-bs-spy="scroll" class="scrollspy-example">
        <section
            style="background: linear-gradient(0deg, rgba(0, 0, 0, 0.50) 0%, rgba(0, 0, 0, 0.50) 100%), url({{ asset('assets/img/landing/hero-9.png') }}) lightgray 50% / cover no-repeat; padding-top: 100px;">
            <div class="container pb-6 d-flex justify-content-center align-items-center">
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
                                    <button id="pay-button" class="btn btn-primary w-100">Checkout</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
