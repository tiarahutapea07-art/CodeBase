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

    <!-- Header Navigation -->
    <header class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-100">
        <nav class="max-w-5xl mx-auto px-6 py-3.5 flex items-center justify-between">
            <a href="/" class="text-xl font-extrabold tracking-tight text-slate-900 flex items-center gap-2">
                <span class="w-7 h-7 bg-emerald-500 rounded-lg flex items-center justify-center text-white text-xs font-black shadow-sm">R</span>
                ReUse<span class="text-emerald-600">Market</span>
            </a>
            <a href="/" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </nav>
    </header>

    <!-- Main Detail Content -->
    <main class="max-w-4xl mx-auto px-4 py-8 md:py-12 w-full flex-grow flex items-center">
        <div class="w-full bg-white rounded-3xl border border-slate-100 p-6 md:p-8 shadow-xl shadow-slate-200/50 grid grid-cols-1 md:grid-cols-12 gap-8 md:gap-10 items-center">
            
            <!-- Foto Produk -->
            <div class="md:col-span-5">
                <div class="relative group aspect-square rounded-2xl overflow-hidden bg-slate-50 border border-slate-100">
                    <img 
                        src="{{ asset($product->image_url ?? 'images/' . $product->image) }}" 
                        alt="{{ $product->name }}" 
                        class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500 ease-out"
                    >
                    <span class="absolute top-3 left-3 bg-white/90 backdrop-blur-md text-amber-700 text-[10px] font-bold px-2.5 py-1 rounded-full border border-amber-200/50 shadow-sm uppercase tracking-wider">
                        ✨ Kondisi: {{ $product->condition }}
                    </span>
                </div>
            </div>

            <!-- Detail Info -->
            <div class="md:col-span-7 flex flex-col justify-between space-y-6">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-emerald-600">Preloved Item</span>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 leading-snug mt-1">
                        {{ $product->name }}
                    </h1>
                    <div class="mt-3 flex items-baseline gap-2">
                        <span class="text-3xl font-black text-emerald-600 tracking-tight">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <!-- Card Deskripsi Ringkas -->
                <div class="bg-slate-50/80 p-4 rounded-2xl border border-slate-100/80">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Deskripsi Produk</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        {{ $product->description }}
                    </p>
                </div>

                <!-- Tombol Aksi Utamanya -->
                <!-- Badge Lokasi Barang -->
                <div class="flex items-center gap-1.5 text-slate-500 text-xs font-medium my-2">
                    <span>📍 {{ $product->location ?? 'Palembang' }}</span>
                </div>

                <!-- Grid Tombol Aksi: Chat & Nego -->
                <div class="grid grid-cols-2 gap-3 pt-3">
                    <!-- Tombol 1: Chat Penjual -->
                    <form action="{{ route('chat.start', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-3 px-4 bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs rounded-xl transition flex items-center justify-center gap-2">
                            💬 Chat Penjual
                        </button>
                    </form>

                    <!-- Tombol 2: Ajukan Nego -->
                    <button onclick="openNegoModal()" class="w-full py-3 px-4 bg-white border-2 border-amber-500 text-amber-600 hover:bg-amber-50 font-bold text-xs rounded-xl transition flex items-center justify-center gap-2">
                        🤝 Ajukan Nego
                    </button>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-100 bg-white py-4 text-center text-xs text-slate-400">
        &copy; 2026 ReUseMarket — Thrift & Preloved Marketplace.
    </footer>

</body>
</html>