
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Favorit Saya - ReUseMarket</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-emerald-50/30 font-sans">

    <main class="w-full max-w-7xl mx-auto p-5 md:p-8">

        
    {{-- HEADER --}}
    <div class="mb-8">

        {{-- NAVBAR KECIL --}}
        <div class="flex items-center justify-between border-b border-emerald-100 pb-5 mb-8">
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
                                        onclick="hapusFavorit(this)"
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

        <div class="mt-10 text-center text-xs text-gray-400">
            © {{ date('Y') }} ReUseMarket. All rights reserved.
        </div>

    </main>

    <script>
        async function hapusFavorit(button) {
            if (!confirm('Yakin ingin menghapus barang ini dari favorit?')) return;

            button.disabled = true;
            button.textContent = 'Menghapus...';

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

                    if (grid.children.length === 0) {
                        location.reload();
                    }
                } else {
                    throw new Error();
                }

            } catch (error) {
                alert('Gagal menghapus favorit. Silakan coba lagi.');
                button.disabled = false;
                button.textContent = '♥ Hapus Favorit';
            }
        }
    </script>

</body>
</html>