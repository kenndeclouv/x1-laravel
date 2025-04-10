{{-- @extends('landing.components.layouts.master')
@section('title', 'Home')

@section('content')
    <!-- Sections:Start -->
    <div data-bs-spy="scroll" class="scrollspy-example">
        <section
            style="background: linear-gradient(0deg, rgba(0, 0, 0, 0.50) 0%, rgba(0, 0, 0, 0.50) 100%), url({{ asset('assets/img/landing/hero-1.png') }}) lightgray 50% / cover no-repeat;">
            <div class="container ">
                <img src="{{ asset('assets/img/landing/output.png') }}" alt="" class="vw-100">
            </div>
        </section>
    </div>
    <!-- / Sections:End -->
@endsection --}}
@extends('landing.components.layouts.master')
@section('title', 'Home')
@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/leaflet/leaflet.css') }}">
@endsection
@section('page-script')
    <script src="{{ asset('assets/vendor/libs/leaflet/leaflet.js') }}"></script>
    {{-- <script>
        const tileSize = 256;
        const numTilesX = 200; // ganti sesuai jumlah tile horizontal
        const numTilesY = 105; // ganti sesuai jumlah tile vertikal

        const map = L.map('map', {
            crs: L.CRS.Simple,
            minZoom: 0,
            maxZoom: 0,
            zoomControl: false
        }).setView([numTilesY * tileSize / 2, numTilesX * tileSize / 2], 0);

        const bounds = [
            [0, 0],
            [numTilesY * tileSize, numTilesX * tileSize]
        ];
        map.setMaxBounds(bounds);

        const MyTileLayer = L.GridLayer.extend({
            createTile: function(coords) {
                const tile = document.createElement('img');
                const x = coords.x;
                const y = coords.y;

                if (x < 0 || y < 0 || x >= numTilesX || y >= numTilesY) {
                    tile.style.display = 'none';
                    return tile;
                }

                tile.src = `/assets/img/landing/maps/${x}/${y}.png`;
                tile.width = tileSize;
                tile.height = tileSize;
                // tile.onerror = () => tile.style.display = 'none';

                return tile;
            }
        });

        const tiles = new MyTileLayer({
            tileSize: tileSize,
            noWrap: true,
            bounds: bounds
        });

        tiles.addTo(map);
    </script> --}}
    <script>
        var mymap = L.map('map', {
            crs: L.CRS.Simple, // Penting untuk peta non-geografis
            minZoom: 0,
            maxZoom: 3 // Sesuaikan dengan kebutuhan zoom kamu
        }).setView([0, 0], 0);

        var tileSize = 256;
        var imageWidth = 51200;
        var imageHeight = 26751;

        L.gridLayer({
            tileSize: tileSize,
            bounds: [
                [0, 0],
                [imageHeight, imageWidth] // Sesuaikan dengan dimensi gambar asli
            ],
            minZoom: 0,
            maxZoom: 3
        }).createTile = function(coords) {
            var tile = L.DomUtil.create('img', 'leaflet-tile');
            var x = coords.x;
            var y = coords.y;
            var zoom = coords.z;

            // Karena tidak ada folder z, kita asumsikan ini adalah zoom level 0
            // Kamu perlu menyesuaikan path berdasarkan lokasi tile kamu
            tile.src = '/assets/img/landing/maps/' + x + '/' + y + '.png';

            tile.onload = function() {
                this.classList.add('leaflet-tile-loaded');
            };
            tile.onerror = function() {
                // Handle error loading tile
                console.log('Error loading tile at x: ' + x + ', y: ' + y);
            };

            return tile;
        };

        mymap.addLayer(L.gridLayer);

        // Atur batas peta agar sesuai dengan dimensi gambar
        mymap.setMaxBounds([
            [0, 0],
            [imageHeight, imageWidth]
        ]);
    </script>
@endsection
@section('content')
    <!-- Sections:Start -->
    <div data-bs-spy="scroll" class="scrollspy-example">
        <section
            style="background: linear-gradient(0deg, rgba(0, 0, 0, 0.50) 0%, rgba(0, 0, 0, 0.50) 100%), url({{ asset('assets/img/landing/hero-1.png') }}) lightgray 50% / cover no-repeat;">
            <div class="container ">
                <div id="map" class="vh-100"></div>
                {{-- <img src="{{ asset('assets/img/landing/output.png') }}" alt="" class="vw-100"> --}}
            </div>
        </section>
    </div>
    <!-- / Sections:End -->
@endsection
