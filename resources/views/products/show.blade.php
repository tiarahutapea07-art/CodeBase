
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} — ReUseMarket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>

<body class="bg-[#F8FAFC] text-slate-800 antialiased min-h-screen flex flex-col justify-between">

    <!-- Header -->

<!-- HEADER NAVBAR REUSEMARKET -->
<header class="bg-white sticky top-0 z-50 border-b border-slate-100">
    <nav class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

        <!-- Logo -->
        <a href="{{ route('home') }}"
           class="text-xl font-extrabold tracking-tight text-slate-900 flex items-center gap-2">
            <span class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center text-white text-xs font-black shadow-sm">
                R
            </span>
            ReUse<span class="text-emerald-600">Market</span>
        </a>

        <!-- Tombol Kembali -->
        <a href="{{ route('home') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold transition-all">
            ← Kembali
        </a>

    </nav>
</header>


    <!-- Detail Produk -->
    <main class="max-w-4xl mx-auto px-4 py-8 md:py-12 w-full flex-grow flex items-center">
        <div class="w-full bg-white rounded-3xl border border-slate-100 p-6 md:p-8 shadow-xl shadow-slate-200/50 grid grid-cols-1 md:grid-cols-12 gap-8 md:gap-10 items-center">

            <!-- Foto Produk -->
            <div class="md:col-span-5">
                <div class="relative group aspect-square rounded-2xl overflow-hidden bg-slate-50 border border-slate-100">
                    <img
                        src="{{ str_starts_with($product->image_url ?? '', 'products/')
                            ? asset('storage/' . $product->image_url)
                            : asset($product->image_url ?? 'images/' . $product->image) }}"
                        alt="{{ $product->name }}"
                        class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500 ease-out"
                    >

                    <span class="absolute top-3 left-3 bg-white/90 backdrop-blur-md text-amber-700 text-[10px] font-bold px-2.5 py-1 rounded-full border border-amber-200/50 shadow-sm uppercase tracking-wider">
                        ✨ Kondisi: {{ $product->condition }}
                    </span>
                </div>
            </div>

            <!-- Informasi Produk -->
            <div class="md:col-span-7 flex flex-col justify-between space-y-6">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-emerald-600">
                        Preloved Item
                    </span>

                    <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 leading-snug mt-1">
                        {{ $product->name }}
                    </h1>

                    <div class="mt-3">
                        <span class="text-3xl font-black text-emerald-600 tracking-tight">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="bg-slate-50/80 p-4 rounded-2xl border border-slate-100/80">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">
                        Deskripsi Produk
                    </h3>

                    <p class="text-slate-600 text-sm leading-relaxed">
                        {{ $product->description }}
                    </p>
                </div>

                <!-- Lokasi -->
                <div class="flex items-center gap-1.5 text-slate-500 text-xs font-medium my-2">
                    <span>📍 {{ $product->location ?? 'Palembang' }}</span>
                </div>

                <!-- Tombol Aksi -->
                <div class="grid {{ $product->price == 0 ? 'grid-cols-1' : 'grid-cols-2' }} gap-3 pt-3">

                    <!-- Chat Penjual -->
                    <form action="{{ route('chat.start', $product->id) }}" method="POST">
                        @csrf

                        <button type="submit"
                            class="w-full py-3 px-4 bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs rounded-xl transition flex items-center justify-center gap-2">
                            💬 {{ $product->price == 0 ? 'Hubungi Pemberi Donasi' : 'Chat Penjual' }}
                        </button>
                    </form>

                    <!-- Ajukan Nego -->
                    @if($product->price > 0 && (!auth()->check() || auth()->id() != $product->user_id))
                        <button
                            type="button"
                            onclick="openNegoModal()"
                            class="w-full py-3 px-4 bg-white border-2 border-amber-500 text-amber-600 hover:bg-amber-50 font-bold text-xs rounded-xl transition flex items-center justify-center gap-2">
                            🤝 Ajukan Nego
                        </button>
                    @endif

                </div>
            </div>
        </div>
    </main>

    <!-- MODAL AJUKAN NEGO -->
    <div id="negoModal"
        class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-900/50 backdrop-blur-sm px-4 py-3">

        <div class="bg-white w-full max-w-md rounded-3xl p-4 md:p-5 shadow-2xl relative">

            <!-- Tombol Tutup -->
            <button type="button"
                onclick="closeNegoModal()"
                class="absolute top-4 right-5 text-slate-400 hover:text-slate-700 text-2xl">
                &times;
            </button>

            <div class="mb-6">
                <span class="text-xs font-bold uppercase tracking-widest text-emerald-600">
                    ReUseMarket
                </span>

                <h2 class="text-2xl font-extrabold text-slate-900 mt-2">
                    Ajukan Penawaran
                </h2>

                <p class="text-sm text-slate-500 mt-2">
                    Masukkan harga yang ingin kamu tawarkan kepada penjual.
                </p>
            </div>

            <!-- Harga Asli -->
            <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-4 mb-5">
                <p class="text-xs text-slate-500 mb-1">Harga asli barang</p>

                <p class="text-xl font-extrabold text-emerald-600">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>
            </div>

            <!-- Form Penawaran -->
            <form action="{{ route('negotiations.store', $product->id) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="offered_price" class="block text-sm font-bold text-slate-700 mb-2">
                        Harga yang kamu tawarkan
                    </label>

                    <div class="flex items-center border border-slate-200 rounded-xl overflow-hidden focus-within:border-emerald-500">
                        <span class="bg-slate-50 px-4 py-3 text-sm font-bold text-slate-500 border-r border-slate-200">
                            Rp
                        </span>

                        <input
                            type="number"
                            name="offered_price"
                            id="offered_price"
                            min="1"
                            max="{{ $product->price - 1 }}"
                            step="1"
                            required
                            value="{{ old('offered_price') }}"
                            placeholder="Contoh: 120000"
                            class="w-full px-4 py-3 outline-none text-sm font-semibold"
                        >
                    </div>

                    <p class="text-xs text-slate-400 mt-2">
                        Harga penawaran harus lebih rendah dari harga asli barang.
                    </p>

                    @error('offered_price')
                        <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pesan Tambahan -->
                <div class="mb-6">
                    <label for="message" class="block text-sm font-bold text-slate-700 mb-2">
                        Pesan untuk penjual (Opsional)
                    </label>

                    <textarea
                        name="message"
                        id="message"
                        rows="2"
                        maxlength="255"
                        placeholder="Contoh: Apakah boleh kalau saya tawar dengan harga segini?"
                        class="w-full border border-slate-200 rounded-xl p-3 text-sm outline-none focus:border-emerald-500 resize-none"
                    >{{ old('message') }}</textarea>

                    @error('message')
                        <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Form -->
                <div class="flex gap-3">
                    <button
                        type="button"
                        onclick="closeNegoModal()"
                        class="flex-1 py-3 rounded-xl border border-slate-200 text-slate-600 font-bold text-sm hover:bg-slate-50 transition">
                        Batal
                    </button>

                    <button
                        type="submit"
                        class="flex-1 py-3 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-sm transition">
                        Kirim Penawaran
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="border-t border-slate-100 bg-white py-4 text-center text-xs text-slate-400">
        &copy; 2026 ReUseMarket — Thrift & Preloved Marketplace.
    </footer>

    <!-- JavaScript Modal -->
    <script>
        function openNegoModal() {
            const modal = document.getElementById('negoModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeNegoModal() {
            const modal = document.getElementById('negoModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Tutup modal jika pembeli klik area luar formulir
        document.getElementById('negoModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeNegoModal();
            }
        });

        // Tutup modal dengan tombol Escape
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeNegoModal();
            }
        });

        // Buka kembali modal jika validasi Laravel gagal
        @if($errors->any())
            openNegoModal();
        @endif
    </script>

</body>
</html>
