@extends('landing.components.layouts.master')
@section('title', 'Our Rules')

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
            style="background: linear-gradient(0deg, rgba(0, 0, 0, 0.50) 0%, rgba(0, 0, 0, 0.50) 100%), url({{ asset('assets/img/landing/hero-12.png') }}) lightgray 50% / cover no-repeat; padding-top: 100px;">
            <div class="container pb-6">
                <div class="card" style="background-color: rgba(var(--bs-body-bg-rgb), 0.6); backdrop-filter: blur(10px);">
                    <div class="card-body p-0 pt-6 position-relative">
                        <img src="{{ asset('assets/img/landing/redeem-hero.png') }}" alt=""
                            class="position-absolute top-0 left-0 d-none d-lg-block"
                            style="max-width: 180px; margin-bottom: -10px;">
                        <div class="text-center py-5 position-relative z-10">
                            <h1>Rules</h1>
                            <p>UPDATED AT 03/04/2025</p>
                        </div>
                    </div>
                </div>
                <div class="card mt-6"
                    style="background-color: rgba(var(--bs-body-bg-rgb), 0.6); backdrop-filter: blur(10px);">
                    <div class="card-body p-0 pt-6 position-relative">
                        <div class="text-center">
                            <h2 style="color: var(--bs-info); font-weight: bold; text-transform: uppercase;">Peraturan Grup &
                                Server X1 Community</h2>
                            <ul class="list-group list-group-flush" style="color: #ffffff;">
                                <li class="list-group-item">Dilarang melakukan PvP tanpa persetujuan kedua pemain atau
                                    dalam event resmi.</li>
                                <li class="list-group-item">Dilarang mempromosikan atau mempraktikkan LGBTQ+ serta pacaran
                                    di dalam server.</li>
                                <li class="list-group-item">Jaga kesopanan! Dilarang berkata kasar, rasis, toxic, atau
                                    menghina pemain lain.</li>
                                <li class="list-group-item">Dilarang adu mekanik (pamer skill secara berlebihan hingga
                                    mengganggu pemain lain).</li>
                                <li class="list-group-item">Dilarang menggunakan cheat, hack client, atau aplikasi ilegal
                                    seperti Toolbox.</li>
                                <li class="list-group-item">Griefing dan pencurian barang milik pemain lain tidak
                                    diperbolehkan.</li>
                                <li class="list-group-item">Dilarang mengirim atau membahas konten berbau 18+ serta unsur
                                    kekerasan (gore).</li>
                                <li class="list-group-item">Dilarang berbuat onar, bertindak kasar, atau merusak kedamaian
                                    server.</li>
                                <li class="list-group-item">Dilarang melakukan aktivitas yang bertentangan dengan norma
                                    agama.</li>
                                <li class="list-group-item">Dilarang meminta item berharga kepada Operator atau Admin.
                                </li>
                                <li class="list-group-item">Dilarang membawa masalah pribadi ke ranah umum</li>
                            </ul>
                            <h2 style="color: var(--bs-info); font-weight: bold; text-transform: uppercase;">⚖ Sanksi Pelanggaran
                            </h2>
                            <p style="color: #ffffff;">Barang siapa yang melanggar aturan ini akan dikenakan hukuman
                                berdasarkan kebijaksanaan
                                Owner.</p>
                            <h2 style="color: var(--bs-info); font-weight: bold; text-transform: uppercase;">⚜ Jaga kehormatan,
                                hormati sesama, dan nikmati permainan dengan penuh kebijaksanaan.</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- / Sections:End -->
@endsection
