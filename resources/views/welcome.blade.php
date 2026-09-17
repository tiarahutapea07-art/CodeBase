<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReUseMarket - Thrift & Preloved Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <!-- Header Navbar -->
    <header class="bg-emerald-600 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold tracking-wide">ReUseMarket</h1>
            <span class="text-sm bg-emerald-700 px-3 py-1 rounded-full">Platform Thrift Online</span>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto py-8 px-4">
        <h2 class="text-xl font-bold mb-6 border-b pb-2">Katalog Barang Bekas Terbaru</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($products as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <span class="text-xs bg-amber-100 text-amber-800 px-2 py-1 rounded font-semibold">
                            Kondisi: {{ $product->condition }}
                        </span>
                        <h3 class="text-lg font-bold mt-2">{{ $product->name }}</h3>
                        <p class="text-gray-600 text-sm mt-1">{{ $product->description }}</p>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-emerald-600 font-bold text-lg">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                            <button class="bg-emerald-600 text-white px-3 py-1 rounded text-sm hover:bg-emerald-700">
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