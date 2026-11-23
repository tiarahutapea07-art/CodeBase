
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Favorit Saya - ReUseMarket</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-emerald-50/30 font-sans text-gray-800">

    <main class="max-w-7xl mx-auto px-6 pt-0 pb-8">

        
   
    <!-- HEADER NAVBAR -->
        <div class="bg-white border-b border-emerald-100 -mx-6 px-6 py-5 mb-8">
            <div class="flex items-center justify-between max-w-7xl mx-auto">
                <a href="{{ route('home') }}"
                class="text-2xl font-bold text-emerald-800 tracking-tight">
                    ReUseMarket
                </a>

                <a href="{{ route('home') }}"
                class="inline-flex items-center gap-2 text-sm font-semibold text-emerald-800 hover:text-emerald-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>

        {{-- JUDUL HALAMAN --}}
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-5">

            <div>
                <div class="inline-flex items-center gap-2 bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full text-xs font-semibold mb-3">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5
                        2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09
                        C13.09 3.81 14.76 3 16.5 3
                        19.58 3 22 5.42 22 8.5
                        c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                    Koleksi Pribadi
                </div>

                <h1 class="text-3xl md:text-4xl font-bold text-gray-800">
                    Favorit Saya
                </h1>

                <p class="text-gray-500 mt-2">
                    Kumpulan barang yang kamu sukai dan simpan.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <span class="bg-white border border-emerald-100 text-gray-600 px-4 py-3 rounded-xl text-sm">
                    <span class="font-bold text-emerald-800">
                        {{ $favorites->count() }}
                    </span>
                    barang tersimpan
                </span>

            </div>

        </div>
    </div>

        {{-- DAFTAR FAVORIT --}}
        @if($favorites->isEmpty())

            <div class="bg-white border border-emerald-100 rounded-2xl shadow-sm p-12 text-center">
                <div class="text-5xl text-red-400 mb-5">♡</div>

                <h3 class="text-xl font-bold text-gray-800">
                    Belum Ada Barang Favorit
                </h3>

                <p class="text-gray-500 mt-2">
                    Yuk, jelajahi produk dan temukan barang yang kamu sukai!
                </p>

                <a href="{{ route('home') }}"
                   class="inline-block mt-6 bg-emerald-800 hover:bg-emerald-900 text-white px-6 py-3 rounded-xl font-semibold">
                    Mulai Jelajahi Produk
                </a>
            </div>

        @else

            <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-5">

                @foreach($favorites as $favorite)

                    @if($favorite->product)

                        <div class="group bg-white border border-emerald-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition">

                            {{-- GAMBAR --}}
                            <div class="relative aspect-square bg-gray-100 overflow-hidden">

                                @if($favorite->product->image_url)
                                    <img
                                        src="{{ str_starts_with($favorite->product->image_url ?? '', 'products/')
                                            ? asset('storage/' . $favorite->product->image_url)
                                            : asset($favorite->product->image_url) }}"
                                        alt="{{ $favorite->product->name }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        Tidak ada gambar
                                    </div>
                                @endif

                                <div class="absolute top-3 right-3 w-9 h-9 rounded-full bg-white shadow flex items-center justify-center">
                                    <span class="text-xl text-red-500">♥</span>
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
                                        <p class="text-emerald-800 font-bold">
                                            Rp {{ number_format($favorite->product->price, 0, ',', '.') }}
                                        </p>
                                    @endif
                                </div>

                                <a href="{{ route('products.show', $favorite->product->id) }}"
                                   class="block text-center w-full bg-emerald-800 hover:bg-emerald-900 text-white rounded-lg py-2.5 text-sm font-semibold transition">
                                    Lihat Produk
                                </a>

                                <button type="button"
                                onclick="bukaModalHapus(this)"
                                data-url="{{ route('favorites.toggle', $favorite->product->id) }}"
                                data-name="{{ $favorite->product->name }}"
                                class="w-full border border-red-200 text-red-500 hover:bg-red-50 rounded-lg py-2.5 text-sm font-semibold transition mt-2">
                            ♥ Hapus Favorit
                        </button>

                            </div>
                        </div>

                    @endif

                @endforeach

            </div>

        @endif

        <div class="mt-10 text-center text-xs text-gray-400">
            © {{ date('Y') }} ReUseMarket. All rights reserved.
        </div>

    </main>

        </main>

    <!-- MODAL KONFIRMASI HAPUS FAVORIT -->
    <div id="modalHapus"
         class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4"
         onclick="tutupModalHapus()">

        <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl p-6"
             onclick="event.stopPropagation()">

            <div class="text-center">

                <div class="w-16 h-16 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">
                    ♥
                </div>

                <h2 class="text-xl font-bold text-gray-800">
                    Hapus Barang Favorit?
                </h2>

                <p class="text-sm text-gray-500 mt-2">
                    Apakah kamu yakin ingin menghapus
                    <span id="namaProdukHapus" class="font-bold text-gray-700"></span>
                    dari daftar favorit?
                </p>

                <div class="flex gap-3 mt-6">

                    <button type="button"
                            onclick="tutupModalHapus()"
                            class="flex-1 py-3 rounded-xl border border-gray-300 text-gray-600 font-semibold hover:bg-gray-50">
                        Batal
                    </button>

                    <button type="button"
                            id="btnKonfirmasiHapus"
                            onclick="konfirmasiHapus()"
                            class="flex-1 py-3 rounded-xl bg-red-500 text-white font-semibold hover:bg-red-600">
                        Ya, Hapus
                    </button>

                </div>

            </div>
        </div>
    </div>

    <script>
    let tombolFavoritAktif = null;

    // Membuka modal
    function bukaModalHapus(button) {
        tombolFavoritAktif = button;

        document.getElementById('namaProdukHapus').textContent =
            button.dataset.name;

        const modal = document.getElementById('modalHapus');

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    // Menutup modal
    function tutupModalHapus() {
        const modal = document.getElementById('modalHapus');

        modal.classList.add('hidden');
        modal.classList.remove('flex');

        tombolFavoritAktif = null;
    }

    // Menghapus favorit setelah dikonfirmasi
    async function konfirmasiHapus() {
        if (!tombolFavoritAktif) return;

        const button = tombolFavoritAktif;
        const tombolKonfirmasi = document.getElementById('btnKonfirmasiHapus');

        tombolKonfirmasi.disabled = true;
        tombolKonfirmasi.textContent = 'Menghapus...';

        try {
            const response = await fetch(button.dataset.url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) throw new Error();

            const result = await response.json();

            if (result.success && result.favorited === false) {

                const card = button.closest('.group');
                const grid = card.parentElement;

                card.remove();

                tutupModalHapus();

                // Jika sudah tidak ada barang favorit
                if (grid.children.length === 0) {
                    location.reload();
                }

            } else {
                throw new Error();
            }

        } catch (error) {
            alert('Gagal menghapus favorit. Silakan coba lagi.');
        }

        tombolKonfirmasi.disabled = false;
        tombolKonfirmasi.textContent = 'Ya, Hapus';
    }
</script>

</body>
</html>