 
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang Saya - ReUseMarket</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">

<div class="flex min-h-screen">

    <!-- SIDEBAR PENGGUNA -->
    <x-user-sidebar active="my-products" />

    <!-- KONTEN UTAMA -->
    <main class="flex-1 min-w-0 p-6 md:p-10">

        <!-- HEADER -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Barang Saya
                </h1>
                <p class="text-gray-500 mt-2">
                    Kelola barang yang telah kamu tambahkan di ReUseMarket.
                </p>
            </div>

            <a href="{{ route('products.create') }}"
               class="inline-flex items-center justify-center gap-2 bg-emerald-700 hover:bg-emerald-800 text-white px-6 py-3 rounded-xl font-semibold transition shadow">
                <span class="text-xl">+</span>
                Tambah Barang
            </a>
        </div>

        <!-- RINGKASAN -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
            <p class="text-gray-500 text-sm mb-2">
                Total Barang Saya
            </p>

            <div class="flex items-center gap-3">
                <h2 class="text-3xl font-bold text-emerald-700">
                    {{ $totalProducts }}
                </h2>
                <span class="text-gray-500">Barang</span>
            </div>
        </div>

        <!-- PESAN BERHASIL -->
        @if(session('success'))
            <div class="bg-green-100 text-green-700 px-5 py-3 rounded-xl mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- DAFTAR BARANG -->
        <div class="mb-5">
            <h2 class="text-xl font-bold text-gray-800">
                Daftar Barang
            </h2>
            <p class="text-gray-500 text-sm mt-1">
                Berikut barang yang sudah kamu tambahkan.
            </p>
        </div>

        @if($products->count() > 0)

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">

                @foreach($products as $product)

                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition">

                        <!-- FOTO BARANG -->
                        <div class="h-52 bg-gray-100">
                            @if($product->image_url)
                                <img
                                    src="{{ str_starts_with($product->image_url, 'products/')
                                        ? asset('storage/' . $product->image_url)
                                        : asset($product->image_url) }}"
                                    alt="{{ $product->name }}"
                                    class="w-full h-full object-cover"
                                >
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    Tidak ada foto
                                </div>
                            @endif
                        </div>

                        <!-- INFORMASI BARANG -->
                        <div class="p-5">

                            <div class="flex items-center justify-between gap-2 mb-3">
                                <span class="text-xs font-semibold px-3 py-1 rounded-full
                                    {{ $product->price > 0
                                        ? 'bg-emerald-100 text-emerald-700'
                                        : 'bg-blue-100 text-blue-700' }}">
                                    {{ $product->price > 0 ? 'Dijual' : 'Donasi' }}
                                </span>

                                <span class="text-xs text-gray-500">
                                    {{ $product->condition }}
                                </span>
                            </div>

                            <h3 class="text-lg font-bold text-gray-800 mb-2">
                                {{ $product->name }}
                            </h3>

                            <p class="text-sm text-gray-500 mb-3">
                                {{ $product->category->name ?? 'Tanpa Kategori' }}
                            </p>

                            <p class="text-lg font-bold text-emerald-700 mb-4">
                                {{ $product->price > 0
                                    ? 'Rp ' . number_format($product->price, 0, ',', '.')
                                    : 'Gratis / Donasi' }}
                            </p>

                            <!-- TOMBOL LIHAT DETAIL -->
                            <a href="{{ route('products.show', $product->id) }}"
                            class="block text-center border border-emerald-700 text-emerald-700 hover:bg-emerald-700 hover:text-white py-2.5 rounded-xl font-semibold transition mb-3">
                                Lihat Detail
                            </a>

                            <!-- TOMBOL EDIT DAN HAPUS -->
                            <div class="grid grid-cols-2 gap-3">

                                <a href="{{ route('my-products.edit', $product->id) }}"
                                class="text-center bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-xl font-semibold transition">
                                    Edit
                                </a>

                                <form action="{{ route('my-products.destroy', $product->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Apakah kamu yakin ingin menghapus barang ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="w-full bg-red-600 hover:bg-red-700 text-white py-2.5 rounded-xl font-semibold transition">
                                        Hapus
                                    </button>

                                </form>

                            </div>

                        </div>
                    </div>

                @endforeach

            </div>

        @else

            <!-- JIKA BELUM ADA BARANG -->
            <div class="bg-white border border-gray-100 rounded-2xl p-12 text-center shadow-sm">

                <div class="text-6xl mb-5">📦</div>

                <h3 class="text-xl font-bold text-gray-800 mb-2">
                    Belum Ada Barang
                </h3>

                <p class="text-gray-500 mb-6">
                    Kamu belum menambahkan barang. Mulai jual atau donasikan barangmu sekarang!
                </p>

                <a href="{{ route('products.create') }}"
                   class="inline-flex items-center gap-2 bg-emerald-700 hover:bg-emerald-800 text-white px-6 py-3 rounded-xl font-semibold transition">
                    + Tambah Barang
                </a>

            </div>

        @endif

    </main>

</div>

</body>
</html>
