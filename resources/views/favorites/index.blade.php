 
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Favorit Saya - ReUseMarket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>

<body class="bg-emerald-50/30">

<div class="flex h-screen overflow-hidden">

    {{-- SIDEBAR --}}
    <x-user-sidebar active="favorites" />

    {{-- KONTEN UTAMA --}}
    <main class="flex-1 min-w-0 overflow-y-auto p-5 md:p-8">

        {{-- HEADER --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">

            <div>
                <p class="text-sm text-emerald-700 font-semibold mb-1">
                    ReUseMarket / Dashboard
                </p>

                <h1 class="text-3xl font-bold text-gray-800">
                    Favorit Saya
                </h1>

                <p class="text-gray-500 mt-2">
                    Kumpulan barang yang kamu sukai dan simpan.
                </p>
            </div>

            <a href="{{ route('home') }}"
               class="inline-flex items-center justify-center gap-2 bg-emerald-800 hover:bg-emerald-900 text-white px-5 py-3 rounded-xl font-semibold shadow-sm transition">
                <span>＋</span>
                Jelajahi Produk
            </a>

        </div>

        {{-- NOTIFIKASI --}}
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-100 border border-green-200 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- RINGKASAN --}}

        {{-- DAFTAR FAVORIT --}}
        <div class="mb-5 flex items-center justify-between">

            <div>
                <h2 class="text-xl font-bold text-gray-800">
                    Koleksi Favorit
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Barang yang telah kamu tandai.
                </p>
            </div>

        </div>

        @if($favorites->isEmpty())

            {{-- KETIKA FAVORIT KOSONG --}}
            <div class="bg-white border border-emerald-100 rounded-2xl shadow-sm p-12 text-center">

                <div class="w-20 h-20 mx-auto rounded-full bg-red-50 flex items-center justify-center mb-5">
                    <span class="text-5xl text-red-400">♡</span>
                </div>

                <h3 class="text-xl font-bold text-gray-800">
                    Belum Ada Barang Favorit
                </h3>

                <p class="text-gray-500 mt-2 max-w-md mx-auto">
                    Kamu belum menyimpan barang favorit.
                    Yuk, jelajahi produk dan temukan barang yang kamu sukai!
                </p>

                <a href="{{ route('home') }}"
                   class="inline-block mt-6 bg-emerald-800 hover:bg-emerald-900 text-white px-6 py-3 rounded-xl font-semibold transition">
                    Mulai Jelajahi Produk
                </a>

            </div>

        @else

            {{-- GRID PRODUK --}}
            <div class="grid grid-cols-2 xl:grid-cols-4 gap-5">

                @foreach($favorites as $favorite)

                    @if($favorite->product)

                        <div class="group bg-white border border-emerald-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-lg hover:-translate-y-1 transition duration-300">

                            {{-- GAMBAR PRODUK --}}
                            <div class="relative aspect-square bg-gray-100 overflow-hidden">

                                @if($favorite->product->image_url)

                                    <img
                                        src="{{ $favorite->product->image_url }}"
                                        alt="{{ $favorite->product->name }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition duration-500">

                                @else

                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <span class="text-sm">Tidak ada gambar</span>
                                    </div>

                                @endif

                                {{-- IKON FAVORIT --}}
                                <div class="absolute top-3 right-3 w-9 h-9 rounded-full bg-white shadow flex items-center justify-center">
                                    <span class="text-xl text-red-500">♥</span>
                                </div>

                                {{-- KONDISI BARANG --}}
                                <div class="absolute bottom-3 left-3 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-semibold text-emerald-800">
                                    {{ $favorite->product->condition }}
                                </div>

                            </div>

                            {{-- INFORMASI PRODUK --}}
                            <div class="p-4">

                                <h3 class="font-bold text-gray-800 text-sm md:text-base truncate">
                                    {{ $favorite->product->name }}
                                </h3>

                                <p class="text-xs text-gray-500 mt-2 line-clamp-2 min-h-8">
                                    {{ $favorite->product->description }}
                                </p>

                                <div class="mt-4 mb-4">

                                    @if($favorite->product->price == 0)

                                        <p class="text-emerald-700 font-bold">
                                            Gratis / Donasi
                                        </p>

                                    @else

                                        <p class="text-emerald-800 font-bold text-base">
                                            Rp {{ number_format($favorite->product->price, 0, ',', '.') }}
                                        </p>

                                    @endif

                                </div>

                                {{-- TOMBOL DETAIL --}}
                                <a href="{{ route('products.show', $favorite->product->id) }}"
                                   class="block text-center w-full bg-emerald-800 hover:bg-emerald-900 text-white rounded-lg py-2.5 text-sm font-semibold transition">
                                    Lihat Produk
                                </a>

                                {{-- HAPUS FAVORIT --}}
                                <button type="button"
                                        onclick="bukaModalFavorit(this)"
                                        data-url="{{ route('favorites.toggle', $favorite->product->id) }}"
                                        class="w-full border border-red-200 text-red-500 hover:bg-red-50 rounded-lg py-2.5 text-sm font-semibold transition mt-2">
                                    ♥ Hapus Favorit
                                </button>

                            </div>

                        </div>

                    @endif

                @endforeach

            </div>

        @endif

        {{-- FOOTER --}}
        <div class="mt-10 text-center text-xs text-gray-400">
            © {{ date('Y') }} ReUseMarket. All rights reserved.
        </div>

    </main>

</div>

<!-- MODAL KONFIRMASI HAPUS FAVORIT -->
<div id="modalFavorit"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-gray-900/50 backdrop-blur-sm p-4">

    <div class="bg-white w-full max-w-sm rounded-3xl shadow-2xl p-7 text-center">

        <!-- IKON -->
        <div class="w-20 h-20 mx-auto rounded-full bg-red-50 flex items-center justify-center mb-5">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-10 h-10 text-red-500"
                 fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.8-7.5 1.1-1.1a5.5 5.5 0 0 0-.1-7.8z"/>
            </svg>
        </div>

        <!-- JUDUL -->
        <h2 class="text-xl font-bold text-gray-800 mb-2">
            Hapus dari Favorit?
        </h2>

        <p class="text-sm text-gray-500 leading-relaxed mb-7">
            Apakah kamu yakin ingin menghapus produk ini dari daftar favoritmu?
        </p>

        <!-- TOMBOL -->
        <div class="flex gap-3">

            <button type="button"
                    onclick="tutupModalFavorit()"
                    class="flex-1 px-4 py-3 rounded-xl border border-gray-200 text-gray-600 font-semibold hover:bg-gray-50 transition">
                Batal
            </button>

            <button type="button"
                    id="btnKonfirmasiHapus"
                    onclick="konfirmasiHapusFavorit()"
                    class="flex-1 px-4 py-3 rounded-xl bg-red-500 hover:bg-red-600 text-white font-semibold shadow-sm transition">
                Ya, Hapus
            </button>

        </div>

    </div>
</div>

<script>
let tombolFavoritAktif = null;

function bukaModalFavorit(button) {
    tombolFavoritAktif = button;

    const modal = document.getElementById('modalFavorit');

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function tutupModalFavorit() {
    const modal = document.getElementById('modalFavorit');

    modal.classList.add('hidden');
    modal.classList.remove('flex');

    tombolFavoritAktif = null;
}

async function konfirmasiHapusFavorit() {

    if (!tombolFavoritAktif) return;

    const button = tombolFavoritAktif;
    const card = button.closest('.group');
    const konfirmasi = document.getElementById('btnKonfirmasiHapus');

    button.disabled = true;
    konfirmasi.disabled = true;
    konfirmasi.textContent = 'Menghapus...';

    try {
        const response = await fetch(button.dataset.url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) {
            throw new Error('Gagal menghapus favorit.');
        }

        const result = await response.json();

        if (result.success && result.favorited === false) {
            card.remove();
            tutupModalFavorit();

            const grid = document.querySelector('.grid.grid-cols-2.xl\\:grid-cols-4');

            if (grid && grid.children.length === 0) {
                location.reload();
            }
        } else {
            throw new Error('Respons server tidak sesuai.');
        }

    } catch (error) {
        alert('Produk gagal dihapus. Silakan coba lagi.');

        button.disabled = false;
        console.error(error);

    } finally {
        konfirmasi.disabled = false;
        konfirmasi.textContent = 'Ya, Hapus';
    }
}
</script>

</body>
</html>