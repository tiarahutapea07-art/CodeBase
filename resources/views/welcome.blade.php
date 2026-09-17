<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReUseMarket - Thrift & Preloved Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#1c1410] text-gray-100">
    <!-- Header Navbar -->
    <header class="bg-[#140d0a] border-b border-[#3d2b1f]">
        <div class="container mx-auto flex justify-between items-center px-4 py-4">
            <h1 class="text-2xl font-extrabold tracking-wide">
                <span class="text-white">Re</span><span class="text-amber-500">Use</span><span class="text-white">Market</span>
            </h1>
            <span class="text-xs bg-[#2a1d16] text-amber-500 px-3 py-1 rounded-full border border-amber-500/30">
                Platform Thrift Online
            </span>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1523381210434-271e8be1f52b?q=80&w=1600&auto=format&fit=crop')] bg-cover bg-center"></div>
        <div class="absolute inset-0 bg-[#1c1410]/80"></div>

        <div class="relative container mx-auto px-4 py-24 grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
            <div>
                <h2 class="text-5xl md:text-6xl font-extrabold leading-tight mb-6">
                    <span class="text-white">RE</span><span class="text-amber-500">USE</span><br>
                    <span class="text-white">MARKET</span>
                </h2>
                <p class="text-gray-300 text-lg max-w-md">
                    Platform jual beli barang bekas berkualitas. Temukan barang preloved terbaik dengan harga terjangkau.
                </p>
            </div>

            @if($products->count())
                @php($featured = $products->first())
                <div class="bg-[#2a1d16] border border-[#4a3527] rounded-xl overflow-hidden shadow-xl max-w-sm justify-self-end">
                    <div class="relative">
                        <span class="absolute top-3 left-3 bg-amber-600 text-black text-xs font-bold px-3 py-1 rounded-full">
                            FEATURED
                        </span>
                        <img src="{{ $featured->image_url }}" alt="{{ $featured->name }}" class="w-full h-56 object-cover">
                    </div>
                    <div class="p-5">
                        <span class="text-xs bg-orange-500/10 text-orange-400 px-2 py-1 rounded font-semibold">
                            Kondisi: {{ $featured->condition }}
                        </span>
                        <h3 class="text-lg font-bold mt-2 text-white">{{ $featured->name }}</h3>
                        <p class="text-gray-400 text-sm mt-1">{{ $featured->description }}</p>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-amber-500 font-bold text-xl">
                                Rp {{ number_format($featured->price, 0, ',', '.') }}
                            </span>
                            <button class="bg-amber-600 text-black font-semibold px-4 py-2 rounded text-sm hover:bg-amber-500 transition">
                                Beli
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Main Content -->
    <main class="container mx-auto py-12 px-4">
        <h2 class="text-xl font-bold mb-6 border-b border-[#3d2b1f] pb-2 text-white">Katalog Barang Bekas Terbaru</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($products as $product)
                <div class="bg-gradient-to-br from-[#2a1d16] via-[#2e1d15] to-[#3d2117] border border-[#4a3527] rounded-lg shadow-md overflow-hidden hover:border-amber-500/60 hover:shadow-[0_0_25px_-5px_rgba(217,119,6,0.4)] transition-all duration-300">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <span class="text-xs bg-orange-500/10 text-orange-400 px-2 py-1 rounded font-semibold">
                            Kondisi: {{ $product->condition }}
                        </span>
                        <h3 class="text-lg font-bold mt-2 text-white">{{ $product->name }}</h3>
                        <p class="text-gray-400 text-sm mt-1">{{ $product->description }}</p>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-amber-500 font-bold text-lg">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                            <button class="bg-amber-600 text-black font-semibold px-3 py-1 rounded text-sm hover:bg-amber-500 transition">
                                Beli
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </main>
</body>
</html>