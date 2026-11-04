<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Pengguna - ReUseMarket</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-emerald-50/30 text-gray-800">

<div class="flex h-screen overflow-hidden">

    <!-- SIDEBAR -->
    <x-user-sidebar active="dashboard" />

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-8 overflow-y-auto">

        <!-- HEADER -->
        <header class="flex justify-between items-center mb-8 gap-5">

            <div class="flex-1">
                <input
                    type="text"
                    placeholder="Cari barang..."
                    class="w-full bg-white border border-gray-200 rounded-full px-5 py-3 outline-none focus:ring-2 focus:ring-emerald-400"
                >
            </div>

            <div class="flex items-center gap-4 flex-shrink-0">

                <!-- NOTIFIKASI -->
                <button type="button" class="text-emerald-700 hover:text-emerald-500 transition">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         width="23" height="23" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"/>
                        <path d="M10 21h4"/>
                    </svg>
                </button>

                <!-- FOTO / INISIAL PENGGUNA -->
                <a href="{{ route('user.dashboard') }}"
                   class="w-10 h-10 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white flex items-center justify-center font-bold shadow-sm transition"
                   title="Dashboard">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </a>

                <span class="font-semibold text-gray-800">
                    {{ auth()->user()->name }}
                </span>

                <!-- KELUAR -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white px-5 py-2.5 rounded-xl font-medium shadow-sm transition">
                        Keluar
                    </button>
                </form>

            </div>
        </header>

        <!-- SELAMAT DATANG -->
        <div class="flex items-center gap-4 mb-8">

            <div class="w-16 h-16 rounded-2xl bg-emerald-100 flex items-center justify-center text-emerald-600">
                <svg xmlns="http://www.w3.org/2000/svg"
                     width="34" height="34" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor"
                     stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="8" r="4"/>
                    <path d="M5 21v-2a7 7 0 0 1 14 0v2"/>
                </svg>
            </div>

            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    Selamat Datang, {{ auth()->user()->name }}!
                </h2>

                <p class="text-sm text-gray-500">
                    Nikmati pengalaman berbelanja di ReUseMarket.
                </p>

                <div class="w-10 h-1 bg-emerald-500 mt-2 rounded"></div>
            </div>

        </div>

        <!-- KARTU STATISTIK DAN BANNER -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-8">

            <!-- BARANG SAYA -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-emerald-100">

                <div class="flex items-center gap-3 mb-5">

                    <div class="w-12 h-12 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             width="25" height="25" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor"
                             stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                            <path d="m3.3 7 8.7 5 8.7-5"/>
                            <path d="M12 22V12"/>
                        </svg>
                    </div>

                    <div>
                        <p class="text-sm text-gray-400">Barang Saya</p>

                        <h3 class="text-2xl font-bold text-gray-800 mt-1">
                            {{ $totalProducts ?? 0 }}
                        </h3>
                    </div>

                </div>

                <a href="#barang-saya"
                class="block text-right text-sm font-semibold text-emerald-600 hover:underline">
                    Lihat Detail →
                </a>

            </div>

            <!-- FAVORIT -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-emerald-100">

                <div class="flex items-center gap-3 mb-5">

                    <div class="w-12 h-12 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             width="25" height="25" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor"
                             stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.8-7.5 1.1-1.1a5.5 5.5 0 0 0-.1-7.8z"/>
                        </svg>
                    </div>

                    <div>
                        <p class="text-sm text-gray-400">Favorit Saya</p>

                        <h3 class="text-2xl font-bold text-gray-800 mt-1">
                            {{ $totalFavorites ?? 0 }}
                        </h3>
                    </div>

                </div>

                <a href="{{ url('/favorit') }}"
                   class="block text-right text-sm font-semibold text-emerald-600 hover:underline">
                    Lihat Detail →
                </a>

            </div>

            <!-- BANNER -->
            <div class="bg-emerald-100 p-5 rounded-2xl flex flex-col justify-center">

                <h3 class="text-lg font-bold text-emerald-950 mb-2">
                    Belanja Lebih Bijak dengan ReUseMarket
                </h3>

                <p class="text-sm text-emerald-800 mb-4">
                    Kurangi limbah, dukung lingkungan!
                </p>

                <a href="{{ route('home') }}"
                   class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold px-4 py-2 rounded-full w-fit transition">
                    Mulai Belanja →
                </a>

            </div>

        </div>

        <!-- BARANG TERBARU -->
        <div id="barang-saya" class="bg-white rounded-2xl shadow-sm border border-emerald-100 overflow-hidden">

            <div class="p-5 border-b border-gray-100 flex justify-between items-center">

                <h3 class="text-lg font-bold text-gray-800 flex items-center gap-3">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         width="23" height="23" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                         class="text-emerald-600">
                        <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                        <path d="m3.3 7 8.7 5 8.7-5"/>
                        <path d="M12 22V12"/>
                    </svg>

                    Barang Terbaru
                </h3>

                <a href="#barang-saya"
                   class="text-emerald-600 text-sm font-semibold hover:underline">
                    Barang Saya →
                </a>

            </div>

            @if(isset($products) && $products->count() > 0)

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5 p-5">

                    @foreach($products->take(6) as $product)

                        <div class="border border-gray-100 rounded-xl overflow-hidden hover:shadow-md transition">

                            @if($product->image_url)
                                <img
                                    src="{{ asset('storage/' . $product->image_url) }}"
                                    alt="{{ $product->name }}"
                                    class="w-full h-44 object-cover"
                                >
                            @else
                                <div class="w-full h-44 bg-emerald-50 flex items-center justify-center text-emerald-600">
                                    Tidak ada gambar
                                </div>
                            @endif

                            <div class="p-4">

                                <h4 class="font-bold text-gray-800 mb-2">
                                    {{ $product->name }}
                                </h4>

                                <p class="text-sm text-gray-500 mb-2">
                                    Kondisi: {{ $product->condition }}
                                </p>

                                <p class="font-semibold text-emerald-700">
                                    @if($product->price == 0)
                                        Donasi
                                    @else
                                        Rp{{ number_format($product->price, 0, ',', '.') }}
                                    @endif
                                </p>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="p-8 text-center text-gray-400">
                    Kamu belum menambahkan barang.
                </div>

            @endif

        </div>

    </main>

</div>

</body>
</html>