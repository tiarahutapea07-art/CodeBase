
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penawaran Nego - ReUseMarket</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-emerald-50/30 text-gray-800 min-h-screen">

    <header class="bg-white border-b border-emerald-100 px-6 py-4">
        <div class="max-w-5xl mx-auto flex justify-between items-center">
            <a href="/" class="font-extrabold text-xl text-emerald-700">
                ReUseMarket
            </a>
            <a href="/" class="text-sm text-gray-500 hover:text-emerald-600">
                Kembali ke Beranda
            </a>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 py-8">

        <h1 class="text-2xl font-bold text-gray-800">
            Penawaran Nego
        </h1>
        <p class="text-gray-500 text-sm mt-1 mb-8">
            Kelola penawaran harga barang di ReUseMarket.
        </p>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-5">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-5">
                {{ session('error') }}
            </div>
        @endif

        <!-- Tawaran Saya -->
        <section class="bg-white rounded-2xl shadow-sm border border-emerald-100 p-6 mb-8">
            <h2 class="text-lg font-bold mb-5">
                Tawaran Saya
            </h2>

            @forelse($myOffers as $offer)
                <div class="border border-gray-100 rounded-xl p-4 mb-3">
                    <h3 class="font-bold">
                        {{ $offer->product->name }}
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Harga asli:
                        Rp {{ number_format($offer->product->price, 0, ',', '.') }}
                    </p>

                    <p class="text-emerald-600 font-bold mt-2">
                        Tawaran saya:
                        Rp {{ number_format($offer->offered_price, 0, ',', '.') }}
                    </p>

                    <p class="text-xs text-gray-500 mt-2">
                        Status:
                        <span class="font-bold">{{ ucfirst($offer->status) }}</span>
                    </p>

                    @if($offer->message)
                        <p class="text-sm text-gray-500 mt-2">
                            Pesan: {{ $offer->message }}
                        </p>
                    @endif
                </div>
            @empty
                <p class="text-gray-400 text-sm">
                    Kamu belum mengajukan penawaran.
                </p>
            @endforelse
        </section>

        <!-- Tawaran Masuk -->
        <section class="bg-white rounded-2xl shadow-sm border border-emerald-100 p-6">
            <h2 class="text-lg font-bold mb-5">
                Tawaran Masuk untuk Produk Saya
            </h2>

            @forelse($incoming as $offer)
                <div class="border border-gray-100 rounded-xl p-4 mb-3">
                    <h3 class="font-bold">
                        {{ $offer->product->name }}
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Pembeli: {{ $offer->buyer->name }}
                    </p>

                    <p class="text-emerald-600 font-bold mt-2">
                        Penawaran:
                        Rp {{ number_format($offer->offered_price, 0, ',', '.') }}
                    </p>

                    @if($offer->message)
                        <p class="text-sm text-gray-500 mt-2">
                            Pesan: {{ $offer->message }}
                        </p>
                    @endif

                    @if($offer->status === 'pending')
                        <div class="flex gap-3 mt-4">
                            <form action="{{ route('negotiations.respond', $offer->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="accepted">
                                <button class="bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm font-bold">
                                    Terima
                                </button>
                            </form>

                            <form action="{{ route('negotiations.respond', $offer->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm font-bold">
                                    Tolak
                                </button>
                            </form>
                        </div>
                    @else
                        <p class="text-sm text-gray-500 mt-3">
                            Status: {{ ucfirst($offer->status) }}
                        </p>
                    @endif
                </div>
            @empty
                <p class="text-gray-400 text-sm">
                    Belum ada penawaran masuk.
                </p>
            @endforelse
        </section>

    </main>
</body>
</html>
