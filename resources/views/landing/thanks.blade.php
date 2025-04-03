@extends('landing.components.layouts.master')
@section('title', 'Rules')
@section('page-script')

@endsection

@section('content')
    <!-- Sections:Start -->
    <div data-bs-spy="scroll" class="scrollspy-example">
        <section
            style="background: linear-gradient(0deg, rgba(0, 0, 0, 0.50) 0%, rgba(0, 0, 0, 0.50) 100%), url({{ asset('assets/img/landing/hero-1.png') }}) lightgray 50% / cover no-repeat;">
            <div class="container ">
                <div class="text-center py-5">
                    <h1 class="text-white" style="font-size: 3rem;">Thank You!</h1>
                    <p class="text-white minecraft-seven-v2" style="font-size: 1.5rem;">Your purchase has been successful. We
                        appreciate your support.</p>
                    <div class="mt-4">
                        <a href="{{ route('landing.index') }}" class="btn btn-primary btn-lg">Back to Home</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- / Sections:End -->
@endsection
