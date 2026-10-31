<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ReUseMarket - Thrift & Preloved Store</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

   
<!-- ================= NAVBAR REUSEMARKET ================= -->
<header class="sticky top-0 z-50 bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-[1440px] mx-auto px-5 py-4">
        <div class="flex flex-wrap lg:flex-nowrap items-center gap-4">

            <!-- Logo -->
            <a href="{{ route('home') }}"
               class="text-2xl font-extrabold tracking-tight whitespace-nowrap">
                <span class="text-emerald-600">Re</span><span class="text-gray-900">UseMarket</span>
            </a>

            <!-- Pilih Lokasi -->
            
<button type="button" id="openLocation"
    class="flex items-center justify-between gap-2 border border-gray-300 rounded-xl px-3 py-3 min-w-[170px] hover:border-emerald-500 transition">

    <span class="flex items-center gap-2 min-w-0">
        <svg class="w-5 h-5 text-emerald-600 shrink-0"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 21s7-6.2 7-12a7 7 0 1 0-14 0c0 5.8 7 12 7 12Z"/>
            <circle cx="12" cy="9" r="2.5"/>
        </svg>

        <span id="selectedLocation"
              class="text-sm text-gray-700 truncate">
            Pilih lokasi
        </span>
    </span>

    <svg class="w-4 h-4 text-gray-500 shrink-0"
         fill="none" stroke="currentColor" viewBox="0 0 24 24"
         aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2"
              d="m6 9 6 6 6-6"/>
    </svg>
</button>

            <!-- Pencarian -->
            <div class="relative flex-1 min-w-[200px]">
                <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="7" stroke-width="2"/>
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2" d="m16 16 4 4"/>
                </svg>
                <input type="text" id="navbarSearch"
                    placeholder="Cari barang preloved..."
                    class="w-full border border-gray-300 rounded-xl pl-11 pr-4 py-3 text-sm outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
            </div>

            <!-- Login / Daftar -->
            <div class="whitespace-nowrap">
                @guest
                    <a href="{{ route('login') }}"
                       class="text-gray-700 hover:text-emerald-700 font-semibold text-sm">
                        Masuk/Daftar
                    </a>
                @else
                    <span class="text-gray-700 text-sm font-medium">
                        {{ auth()->user()->name }}
                    </span>
                @endguest
            </div>

            <!-- Jual -->
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="p-2 text-slate-700 hover:text-emerald-600 hover:bg-slate-100 rounded-xl transition" title="Menu Dashboard">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </a>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('products.create') }}" class="flex items-center gap-1.5 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-[11px] font-bold shadow-sm transition">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                        <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                    </svg>
                    Jual
                </a>
            </div>
            

        </div>
    </div>

    <!-- Popup Peta -->
    <div id="locationPanel"
         class="hidden absolute top-full left-0 w-full bg-white border-t border-gray-200 shadow-xl">
        <div class="max-w-5xl mx-auto p-5">

            <div class="flex justify-between items-center gap-3 mb-4">
                <div>
                    <h3 class="font-bold text-gray-900 text-lg">
                        Pilih Lokasi
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Cari tempat atau pilih titik pada peta.
                    </p>
                </div>
                <button type="button" id="closeLocation"
                    class="text-gray-500 hover:text-gray-900 text-3xl leading-none"
                    aria-label="Tutup peta">&times;</button>
            </div>

            <!-- Cari tempat -->
            <form id="locationSearchForm" class="flex gap-2 mb-3">
                <input type="text" id="locationSearchInput"
                    placeholder="Contoh: Jakabaring, Palembang"
                    class="flex-1 min-w-0 border border-gray-300 rounded-lg px-4 py-3 text-sm outline-none focus:border-emerald-500">
                <button type="submit"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-3 rounded-lg text-sm font-semibold">
                    Cari
                </button>
            </form>

           

            <p id="locationMessage" role="status"
               class="text-sm text-gray-500 mb-3">
                Memuat peta...
            </p>

            <!-- Peta OpenStreetMap -->
            <div id="locationMap"
                 class="w-full h-[350px] rounded-xl border border-gray-200 z-0">
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mt-4">
                <p id="locationCoordinates"
                   class="text-xs text-gray-500">
                    Belum ada titik lokasi yang dipilih.
                </p>
                <button type="button" id="confirmLocation"
                    disabled
                    class="bg-emerald-600 hover:bg-emerald-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-bold px-5 py-3 rounded-lg text-sm">
                    Gunakan Lokasi Ini
                </button>
            </div>

        </div>
    </div>
</header>

<!-- Leaflet: library untuk menampilkan peta interaktif -->
<link rel="stylesheet"
      href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      crossorigin=""/>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        crossorigin=""></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const openButton = document.getElementById('openLocation');
    const closeButton = document.getElementById('closeLocation');
    const panel = document.getElementById('locationPanel');
    const mapElement = document.getElementById('locationMap');
    const searchForm = document.getElementById('locationSearchForm');
    const searchInput = document.getElementById('locationSearchInput');
    const message = document.getElementById('locationMessage');
    const coordinates = document.getElementById('locationCoordinates');
    const confirmButton = document.getElementById('confirmLocation');
    const selectedLocation = document.getElementById('selectedLocation');
    const navbarSearch = document.getElementById('navbarSearch');
    const catalogSearch = document.getElementById('searchProduct');

    let map = null;
    let marker = null;
    let chosenPlace = '';
    let chosenLat = null;
    let chosenLng = null;

    // Sinkronkan pencarian navbar dengan pencarian katalog yang sudah ada.
    if (navbarSearch && catalogSearch) {
        navbarSearch.addEventListener('input', function () {
            catalogSearch.value = this.value;
            catalogSearch.dispatchEvent(new Event('input', {
                bubbles: true
            }));
        });

        catalogSearch.addEventListener('input', function () {
            navbarSearch.value = this.value;
        });
    }

    function selectPoint(lat, lng, place = '') {
        chosenLat = lat;
        chosenLng = lng;
        chosenPlace = place;

        if (marker) {
            marker.setLatLng([lat, lng]);
        } else {
            marker = L.marker([lat, lng]).addTo(map);
        }

        coordinates.textContent =
            `Koordinat: ${lat.toFixed(5)}, ${lng.toFixed(5)}`;

        confirmButton.disabled = false;
        message.textContent = place
            ? `Lokasi dipilih: ${place}`
            : 'Titik dipilih. Klik "Gunakan Lokasi Ini" untuk mengonfirmasi.';
    }

    function initializeMap() {
        if (map) {
            setTimeout(() => map.invalidateSize(), 150);
            return;
        }

        if (typeof L === 'undefined') {
            message.textContent =
                'Peta gagal dimuat. Periksa koneksi internet lalu coba lagi.';
            return;
        }

        // Tampilan awal di Palembang; pengguna bebas memilih lokasi lain.
        map = L.map(mapElement).setView([-2.9761, 104.7754], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener">OpenStreetMap</a> contributors',
            maxZoom: 19
        }).addTo(map);

        map.on('click', function (event) {
            selectPoint(event.latlng.lat, event.latlng.lng);
        });

        message.textContent =
            'Klik pada peta untuk memilih titik lokasi.';
    }

    openButton.addEventListener('click', function () {
        panel.classList.toggle('hidden');

        if (!panel.classList.contains('hidden')) {
            initializeMap();
        }
    });

    closeButton.addEventListener('click', function () {
        panel.classList.add('hidden');
    });

    // Cari tempat secara manual menggunakan Nominatim.
    searchForm.addEventListener('submit', async function (event) {
        event.preventDefault();

        const query = searchInput.value.trim();

        if (!query) {
            message.textContent = 'Masukkan nama kota atau tempat terlebih dahulu.';
            return;
        }

        initializeMap();

        if (!map) return;

        message.textContent = 'Sedang mencari lokasi...';

        try {
            const url = new URL(
                'https://nominatim.openstreetmap.org/search'
            );

            url.searchParams.set('q', query);
            url.searchParams.set('format', 'jsonv2');
            url.searchParams.set('limit', '1');
            url.searchParams.set('accept-language', 'id');

            const response = await fetch(url);

            if (!response.ok) {
                throw new Error('Pencarian lokasi gagal.');
            }

            const results = await response.json();

            if (!results.length) {
                message.textContent = 'Lokasi tidak ditemukan. Coba kata kunci lain.';
                return;
            }

            const result = results[0];
            const lat = Number(result.lat);
            const lng = Number(result.lon);

            map.setView([lat, lng], 15);
            selectPoint(lat, lng, result.display_name);
        } catch (error) {
            message.textContent =
                'Tidak dapat mencari lokasi. Periksa koneksi internet dan coba lagi.';
        }
    });

    // Lokasi perangkat hanya diakses jika pengguna menekan tombol ini.
    document.getElementById('myLocationButton')
        .addEventListener('click', function () {
            initializeMap();

            if (!map) return;

            if (!navigator.geolocation) {
                message.textContent =
                    'Browser ini tidak mendukung fitur lokasi.';
                return;
            }

            message.textContent = 'Meminta izin lokasi perangkat...';

            navigator.geolocation.getCurrentPosition(
                function (position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    map.setView([lat, lng], 16);
                    selectPoint(lat, lng, 'Lokasi perangkat');
                },
                function () {
                    message.textContent =
                        'Lokasi tidak tersedia. Izinkan akses lokasi atau pilih titik pada peta.';
                },
                { enableHighAccuracy: true, timeout: 10000 }
            );
        });

    confirmButton.addEventListener('click', function () {
        if (chosenLat === null || chosenLng === null) return;

        const displayPlace = chosenPlace
            ? chosenPlace.split(',').slice(0, 2).join(', ')
            : `${chosenLat.toFixed(5)}, ${chosenLng.toFixed(5)}`;

        selectedLocation.textContent = displayPlace;
        selectedLocation.title = chosenPlace || displayPlace;

        // Simpan sementara selama halaman masih terbuka.
        window.reuseMarketLocation = {
            name: chosenPlace,
            latitude: chosenLat,
            longitude: chosenLng
        };

        panel.classList.add('hidden');
    });
});
</script>

<!-- ================= HERO REUSEMARKET ================= -->
<section class="relative isolate overflow-hidden bg-white
                min-h-[calc(100vh-86px)]">
    <!-- Foto produk di latar belakang -->
    <div
        class="absolute inset-0 -z-20 bg-cover bg-center"
        style="background-image: url('https://images.unsplash.com/photo-1523381210434-271e8be1f52b?q=80&w=1800&auto=format&fit=crop');">
    </div>
<!-- Gradasi cream ke oranye lembut -->
<div class="absolute inset-0 -z-10
    bg-gradient-to-r
    from-amber-50
    via-orange-50/90
    to-orange-100/30">
</div>

    <!-- Konten Hero -->
    <div class="max-w-7xl mx-auto px-6">
        <div class="min-h-[400px] sm:min-h-[440px] md:min-h-[480px]
                    flex items-center py-14 md:py-20">

            <div class="max-w-xl">

                <p class="text-emerald-700 font-bold
                          tracking-[0.2em] text-xs sm:text-sm
                          mb-4 uppercase">
                    SECONDHAND MARKETPLACE
                </p>

                <h1 class="text-4xl sm:text-5xl md:text-6xl
                           font-black leading-tight tracking-tight
                           text-gray-900">
                    Barang Lama,
                    <span class="text-emerald-600">
                        Cerita Baru.
                    </span>
                </h1>

                <p class="text-gray-600 text-base md:text-lg
                          mt-5 max-w-lg leading-relaxed">
                    Temukan barang preloved berkualitas dengan
                    harga terjangkau. Beri barang lama kesempatan
                    untuk memiliki cerita baru.
                </p>

                <div class="flex flex-wrap gap-3 mt-8">

                    <a href="#katalog"
                       class="inline-flex items-center gap-2
                              bg-emerald-600 hover:bg-emerald-700
                              text-white font-bold px-6 py-3.5
                              rounded-full shadow-sm transition">
                        Jelajahi Barang <span>→</span>
                    </a>

                    <a href="{{ route('login') }}"
                       class="inline-flex items-center
                              border border-emerald-600
                              text-emerald-700 hover:bg-emerald-50
                              font-bold px-6 py-3.5
                              rounded-full transition">
                        Mulai Jual
                    </a>

                </div>
            </div>
        </div>
    </div>
</section>



    <!-- ================= SEARCH & CATEGORY ================= -->
    <section id="kategori"
             class="bg-gray-50 px-6 pt-12 pb-4">
        <div class="max-w-4xl mx-auto">
            
        <!-- Search Icon -->
         <svg
         class="absolute left-5 top-4 w-6 h-6 text-gray-400"
         fill="none"
         stroke="currentColor"
         viewBox="0 0 24 24">
         <path
         stroke-linecap="round"
         stroke-linejoin="round"
         stroke-width="2"
         d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z"/>
        </svg>
    </div>
    
    
    <!-- Category Buttons -->
     <div class="flex flex-wrap justify-center gap-3 mt-6">
         <button
            data-category="all"
            class="category-btn active-category
            px-6 py-2.5 rounded-full
            bg-amber-500 text-whith
            font-semibold text-sm shadow-sm
            transition">
            ⊞ &nbsp; Semua
        </button>

         <button
            data-category="fashion"
            class="category-btn
            px-6 py-2.5 rounded-full
            bg-white border border-gray-300
            text-gray-700 hover:bg-gray-50
            hover:border-amber-500
            hover:text-amber-600
            transition">
            ♧ &nbsp; Fashion
        </button>
    
        <button
            data-category="elektronik"
            class="category-btn
            px-6 py-2.5 rounded-full
            bg-white border border-gray-300
            text-gray-700 hover:bg-gray-50
            hover:border-amber-500
            hover:text-amber-600
            transition">
            ▣ &nbsp; Elektronik
        </button>
    
    
        <button
            data-category="buku"
            class="category-btn
            px-6 py-2.5 rounded-full
            bg-white border border-gray-300
            text-gray-700 hover:bg-gray-50
            hover:border-amber-500
            hover:text-amber-600
            transition">
            ▤ &nbsp; Buku
        </button>
    
    
        <button
            data-category="furniture"
            class="category-btn
            px-6 py-2.5 rounded-full
            bg-white border border-gray-300
            text-gray-700 hover:bg-gray-50
            hover:border-amber-500
            hover:text-amber-600
            transition">
            ▱ &nbsp; Furniture
        </button>
    
        <button
            data-category="lainnya"
            class="category-btn
            px-6 py-2.5 rounded-full
            bg-white border border-gray-300
            text-gray-700 hover:bg-gray-50
            hover:border-amber-500
            hover:text-amber-600
            transition">
            ••• &nbsp; Lainnya
        </button>
        <button
            data-category="donasi"
            class="category-btn
            px-6 py-2.5 rounded-full
            bg-white border border-gray-300
            text-gray-700 hover:bg-gray-50
            hover:border-emerald-500
            hover:text-emerald-600
            transition">
            ♡ &nbsp; Donasi
        </button>
    </div>
</div>
</section>


    <!-- ================= KATALOG ================= -->
    <main id="katalog"
          class="max-w-7xl mx-auto px-6 py-10">

        <!-- Catalog Header -->
        <div class="flex flex-col md:flex-row
                    md:items-end md:justify-between
                    gap-4 mb-8">

            <div>

                <p class="text-amber-600
                          text-sm font-bold
                          tracking-[0.2em] uppercase">

                    Explore

                </p>

                <h2 class="text-3xl font-extrabold
                           text-gray-900 mt-1">

                    Katalog Barang Bekas Terbaru

                </h2>

                <p class="text-gray-600 mt-1">

                    Temukan barang preloved berkualitas
                    dengan harga terjangkau.

                </p>

            </div>

            <div class="flex flex-wrap items-center gap-3">

                <!-- Dropdown Kategori Donasi -->
                <div id="donationCategoryFilter" class="hidden">
                    <select id="donationCategory"
                        class="border border-gray-300 rounded-xl px-3 py-2 text-sm bg-white text-gray-700">

                        <option value="all">Semua Kategori</option>
                        <option value="buku">Buku</option>
                        <option value="fashion">Fashion</option>
                        <option value="elektronik">Elektronik</option>
                        <option value="furniture">Furniture</option>
                        <option value="lainnya">Lainnya</option>

                    </select>
                </div>

                <!-- Jumlah Barang -->
                <p class="text-sm text-gray-500">
                    Menampilkan
                    <span id="productCount" class="text-amber-600 font-bold">
                        {{ $products->count() }}
                    </span>
                    barang
                </p>

            </div>

        </div>


        <!-- Product Grid -->
       <div
    id="productGrid"
    class="grid grid-cols-2 lg:grid-cols-4 gap-5 pb-6 pt-2">
    @foreach($products as $product)
    
    
    <div
        class="product-card group min-w-0
            bg-white
            border border-gray-200
            rounded-2xl
            overflow-hidden shadow-sm hover:shadow-lg
            hover:border-amber-400
            hover:-translate-y-1
            transition-all duration-300"
            
            data-product-name="{{ strtolower($product->name) }}"
            data-product-description="{{ strtolower($product->description) }}"
            data-product-condition="{{ strtolower($product->condition) }}"
            data-product-category="{{ strtolower($product->category->name ?? '') }}"
            data-product-type="{{ $product->price == 0 ? 'donasi' : 'jual' }}"
            
            >

                    <!-- Image -->
                    <div class="relative overflow-hidden bg-gray-100">

                       <img
                            src="{{ str_starts_with($product->image_url ?? '', 'products/')
                                ? asset('storage/' . $product->image_url)
                                : asset($product->image_url) }}"
                            alt="{{ $product->name }}"
                            class="w-full h-56
                                object-cover
                                group-hover:scale-105
                                transition duration-500"
                        >

                        <!-- Badge Jenis Barang -->
                        @if($product->price == 0)
                            <span class="absolute top-3 left-3 bg-emerald-600 text-white text-[11px] font-bold px-3 py-1 rounded-full shadow">
                                DONASI
                            </span>
                        @else
                            <span class="absolute top-3 left-3 bg-amber-500 text-white text-[11px] font-bold px-3 py-1 rounded-full shadow">
                                PRELOVED
                            </span>
                        @endif

                        <!-- Favorite -->
                        <button
                            class="absolute top-3 right-3
                                   w-9 h-9
                                   rounded-full
                                   bg-white/80
                                   backdrop-blur-sm
                                   flex items-center justify-center
                                   text-gray-600
                                   hover:text-red-500 hover:bg-white
                                   transition shadow-sm">

                            ♡

                        </button>

                    </div>


                    <!-- Product Info -->
                    <div class="p-5">

                        <!-- Condition -->
                        <span
                            class="inline-block
                                   text-[11px]
                                   font-semibold
                                   bg-amber-100
                                   text-amber-800
                                   px-2.5 py-1
                                   rounded-full">

                            Kondisi: {{ $product->condition }}

                        </span>


                        <!-- Name -->
                        <h3
                            class="text-base font-bold
                                   text-gray-900
                                   mt-3
                                   group-hover:text-amber-600
                                   transition">

                            {{ $product->name }}

                        </h3>


                        <!-- Description -->
                        <p
                            class="text-gray-500
                                   text-xs
                                   mt-2
                                   line-clamp-2">

                            {{ $product->description }}

                        </p>


                        <!-- Price + Button -->
                        <div
                            class="flex items-end
                                   justify-between
                                   gap-2
                                   mt-5 pt-3 border-t border-gray-100">

                            <div>

                                <p class="text-[10px]
                                          text-gray-400
                                          uppercase font-semibold
                                          mb-0.5">

                                    Harga

                                </p>

                                @if($product->price == 0)
                                    <p class="text-emerald-600 font-extrabold text-lg">
                                        GRATIS
                                    </p>
                                @else
                                    <p class="text-amber-600 font-extrabold text-lg">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>
                                @endif

                            </div>


                            <a href="{{ route('products.show', $product) }}"
   class="border border-amber-500 text-amber-600 hover:bg-amber-500 hover:text-white font-bold text-xs px-3.5 py-2 rounded-full transition">
    Lihat Detail
</a>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>


        <!-- Empty Search -->
        <div
            id="emptyMessage"
            class="hidden text-center py-20">

            <div class="text-5xl mb-4">
                🔍
            </div>

            <h3 class="text-xl font-bold text-gray-800">
                Barang tidak ditemukan
            </h3>

            <p class="text-gray-500 mt-2">
                Coba gunakan kata kunci yang berbeda.
            </p>

        </div>

    </main>


    <!-- ================= ABOUT ================= -->
    <section id="tentang"
             class="border-t border-gray-200
                    bg-white">

        <div class="max-w-7xl mx-auto
                    px-6 py-16">

            <div class="max-w-2xl">

                <p class="text-amber-600
                          text-sm font-bold
                          tracking-[0.2em] uppercase">

                    Tentang Kami

                </p>

                <h2 class="text-3xl
                           font-extrabold
                           text-gray-900 mt-2">

                    Barang Lama, Cerita Baru.

                </h2>

                <p class="text-gray-600
                          mt-4 leading-relaxed">

                    ReUseMarket merupakan platform jual beli barang
                    bekas dan preloved yang membantu pengguna menemukan
                    barang berkualitas dengan harga yang lebih terjangkau.

                    Kami percaya bahwa barang yang sudah pernah digunakan
                    masih bisa memiliki nilai dan cerita baru.

                </p>

            </div>

        </div>

    </section>


    <!-- ================= FOOTER ================= -->
    <footer id="kontak"
            class="bg-gray-100
                   border-t border-gray-200">

        <div class="max-w-7xl mx-auto
                    px-6 py-12">

            <div class="grid grid-cols-1
                        md:grid-cols-3
                        gap-8">

                <!-- Brand -->
                <div>

                    <h3 class="text-xl font-extrabold">

                        <span class="text-emerald-600">Re</span><span class="text-amber-600">Use</span><span class="text-gray-900">Market</span>

                    </h3>

                    <p class="text-gray-500
                              text-sm mt-2">

                        Barang bekas, peluang baru.

                    </p>

                </div>


                <!-- Navigation -->
                <div>

                    <h4 class="text-gray-900 font-semibold mb-3">
                        Navigasi
                    </h4>

                    <div class="flex flex-col gap-2
                                text-sm text-gray-600">

                        <a href="#"
                           class="hover:text-amber-600 transition">
                            Beranda
                        </a>

                        <a href="#kategori"
                           class="hover:text-amber-600 transition">
                            Kategori
                        </a>

                        <a href="#tentang"
                           class="hover:text-amber-600 transition">
                            Tentang Kami
                        </a>

                    </div>

                </div>


                <!-- Contact -->
                <div>

                    <h4 class="text-gray-900 font-semibold mb-3">
                        Kontak
                    </h4>

                    <p class="text-gray-600 text-sm">
                        Email: reusemarket@gmail.com
                    </p>

                    <p class="text-gray-600 text-sm mt-2">
                        Instagram: @reusemarket
                    </p>

                </div>

            </div>


            <!-- Copyright -->
            <div
                class="border-t border-gray-200
                       mt-10 pt-6
                       flex flex-col md:flex-row
                       justify-between
                       gap-3
                       text-xs text-gray-500">

                <p>
                    © 2025 ReUseMarket.
                    All rights reserved.
                </p>

                <p>
                    Platform Thrift & Preloved Online
                </p>

            </div>

            <!-- Modal Detail Produk (Popup Warm Amber/Orange Theme) -->
            <div id="productModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity duration-300">
                
                <!-- Kartu Modal Container -->
                <div class="relative w-full max-w-2xl bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-100 transform transition-all scale-95 opacity-0 duration-300" id="modalCard">
                    
                    <!-- Tombol Close (Silang) -->
                    <button onclick="closeProductModal()" class="absolute top-4 right-4 z-10 w-9 h-9 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-full flex items-center justify-center transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <!-- Content Grid Modal -->
                    <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-8 items-center">
                        
                        <!-- Foto Produk -->
                        <div class="md:col-span-5">
                            <div class="relative aspect-square rounded-2xl overflow-hidden bg-amber-50/50 border border-amber-100 shadow-inner">
                                <img id="modalImage" src="" alt="Produk" class="w-full h-full object-cover">
                                <span id="modalCondition" class="absolute top-3 left-3 bg-white/95 backdrop-blur-md text-amber-800 text-[10px] font-bold px-2.5 py-1 rounded-full border border-amber-200/60 uppercase tracking-wider shadow-sm">
                                    ✨ Kondisi: -
                                </span>
                            </div>
                        </div>

                        <!-- Detail Info -->
                        <div class="md:col-span-7 space-y-4">
                            <div>
                                <span class="text-xs font-bold uppercase tracking-widest text-amber-600">PRELOVED ITEM</span>
                                <h2 id="modalTitle" class="text-xl md:text-2xl font-extrabold text-slate-900 leading-snug mt-1">
                                    Nama Produk
                                </h2>
                                <p class="text-2xl font-black text-amber-600 tracking-tight mt-2">
                                    Rp <span id="modalPrice">0</span>
                                </p>
                            </div>

                            <!-- Deskripsi -->
                            <div class="bg-amber-50/40 p-3.5 rounded-2xl border border-amber-100/80 max-h-32 overflow-y-auto">
                                <h4 class="text-[11px] font-bold text-amber-800/60 uppercase tracking-wider mb-1">DESKRIPSI PRODUK</h4>
                                <p id="modalDescription" class="text-slate-600 text-xs leading-relaxed">
                                    Deskripsi produk...
                                </p>
                            </div>

                            <!-- Tombol Aksi Oranye -->
                            <div class="space-y-2 pt-1">
                                <button class="w-full py-3.5 px-5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-bold text-xs rounded-xl shadow-lg shadow-emerald-600/20 hover:shadow-emerald-600/30 transition-all flex items-center justify-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 005.474 5.474l.772-1.548a1 1 0 011.06-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                    </svg>
                                    Hubungi Penjual Sekarang
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </footer>


    <!-- ================= SEARCH & FILTER SCRIPT ================= -->
    <script>
        const searchInput = document.getElementById('searchProduct');
        const productCards = document.querySelectorAll('.product-card');
        const productCount = document.getElementById('productCount');
        const emptyMessage = document.getElementById('emptyMessage');
        const categoryButtons = document.querySelectorAll('.category-btn');

        const donationCategoryFilter = document.getElementById('donationCategoryFilter');
        const donationCategory = document.getElementById('donationCategory');

        let selectedCategory = 'all';

        function filterProducts() {
            const keyword = searchInput
                ? searchInput.value.toLowerCase().trim()
                : '';

            const selectedDonationCategory = donationCategory
                ? donationCategory.value
                : 'all';

            let visibleProducts = 0;

            productCards.forEach(card => {
                const name = card.dataset.productName || '';
                const description = card.dataset.productDescription || '';
                const condition = card.dataset.productCondition || '';
                const category = (card.dataset.productCategory || '').toLowerCase();
                const type = card.dataset.productType || '';

                const text = `${name} ${description} ${condition} ${category}`;

                let categoryMatch = true;

                if (selectedCategory === 'donasi') {
                    categoryMatch = type === 'donasi';

                    if (selectedDonationCategory !== 'all') {
                        categoryMatch = categoryMatch &&
                            category === selectedDonationCategory;
                    }
                } else if (selectedCategory !== 'all') {
                    categoryMatch = category === selectedCategory;
                }

                const searchMatch = text.includes(keyword);

                if (categoryMatch && searchMatch) {
                    card.classList.remove('hidden');
                    visibleProducts++;
                } else {
                    card.classList.add('hidden');
                }
            });

            if (productCount) {
                productCount.textContent = visibleProducts;
            }

            if (emptyMessage) {
                emptyMessage.classList.toggle('hidden', visibleProducts > 0);
            }

            if (donationCategoryFilter) {
                donationCategoryFilter.classList.toggle(
                    'hidden',
                    selectedCategory !== 'donasi'
                );
            }
        }

        if (searchInput) {
            searchInput.addEventListener('input', filterProducts);
        }

        if (donationCategory) {
            donationCategory.addEventListener('change', filterProducts);
        }

        categoryButtons.forEach(button => {
            button.addEventListener('click', function () {
                selectedCategory = this.dataset.category;

                categoryButtons.forEach(btn => {
                    btn.classList.remove(
                        'active-category',
                        'bg-amber-500',
                        'text-white',
                        'shadow-sm'
                    );

                    btn.classList.add(
                        'bg-white',
                        'border',
                        'border-gray-300',
                        'text-gray-700'
                    );
                });

                this.classList.add(
                    'active-category',
                    'bg-amber-500',
                    'text-white',
                    'shadow-sm'
                );

                this.classList.remove(
                    'bg-white',
                    'border-gray-300',
                    'text-gray-700'
                );

                filterProducts();
            });
        });
        // ==========================================
        // EVENT LISTENER MODAL DETAIL (AMAN & ANTI-ERROR)
        // ==========================================
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('productModal');
            const modalCard = document.getElementById('modalCard');

            // Buka Modal saat Tombol Detail Diklik
            document.addEventListener('click', function (e) {
                const btn = e.target.closest('.btn-detail');
                if (btn) {
                    const title = btn.dataset.title;
                    const price = btn.dataset.price;
                    const condition = btn.dataset.condition;
                    const description = btn.dataset.description;
                    const image = btn.dataset.image;

                    if (document.getElementById('modalTitle')) document.getElementById('modalTitle').innerText = title;
                    if (document.getElementById('modalPrice')) document.getElementById('modalPrice').innerText = price;
                    if (document.getElementById('modalCondition')) document.getElementById('modalCondition').innerText = '✨ Kondisi: ' + condition;
                    if (document.getElementById('modalDescription')) document.getElementById('modalDescription').innerText = description;
                    if (document.getElementById('modalImage')) document.getElementById('modalImage').src = image;

                    if (modal && modalCard) {
                        modal.classList.remove('hidden');
                        setTimeout(() => {
                            modalCard.classList.remove('scale-95', 'opacity-0');
                            modalCard.classList.add('scale-100', 'opacity-100');
                        }, 10);
                    }
                }
            });

            // Tutup Modal jika Area Luar diklik
            if (modal) {
                modal.addEventListener('click', function (e) {
                    if (e.target === this) {
                        closeProductModal();
                    }
                });
            }
        });

        function closeProductModal() {
            const modal = document.getElementById('productModal');
            const modalCard = document.getElementById('modalCard');

            if (modal && modalCard) {
                modalCard.classList.remove('scale-100', 'opacity-100');
                modalCard.classList.add('scale-95', 'opacity-0');

                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }
        }
    </script>

</body>
</html>