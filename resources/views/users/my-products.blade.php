 
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
                                    class="delete-product-form">

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

<!-- MODAL KONFIRMASI HAPUS -->
<div id="deleteModal"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">

    <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl p-6 md:p-8 relative">

        <!-- TOMBOL TUTUP -->
        <button type="button"
                id="closeDeleteModal"
                class="absolute top-5 right-5 text-gray-400 hover:text-gray-700 text-3xl">
            &times;
        </button>

        <!-- IKON DAN JUDUL -->
        <div class="flex items-center gap-4 mb-5">
            <div class="w-16 h-16 rounded-full bg-emerald-100 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-9 h-9 text-emerald-700"
                     fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3M4 7h16"/>
                </svg>
            </div>

            <h2 class="text-xl md:text-2xl font-bold text-emerald-800">
                Konfirmasi Hapus Barang
            </h2>
        </div>

        <!-- PESAN -->
        <p class="text-gray-800 font-medium mb-4">
            Apakah kamu yakin ingin menghapus barang ini?
        </p>

        <p class="text-sm text-gray-500 mb-7">
            Barang yang dihapus tidak dapat dikembalikan.
        </p>

        <!-- TOMBOL -->
        <div class="border-t border-gray-100 pt-5 flex justify-end gap-3">

            <button type="button"
                    id="cancelDelete"
                    class="px-6 py-3 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-semibold">
                Batal
            </button>

            <button type="button"
                    id="confirmDelete"
                    class="px-6 py-3 rounded-xl bg-emerald-800 hover:bg-emerald-900 text-white font-semibold">
                Ya, Hapus
            </button>

        </div>
    </div>
</div>

<script>
    const deleteModal = document.getElementById('deleteModal');
    const closeDeleteModal = document.getElementById('closeDeleteModal');
    const cancelDelete = document.getElementById('cancelDelete');
    const confirmDelete = document.getElementById('confirmDelete');

    let selectedDeleteForm = null;

    // Membuka modal
    document.querySelectorAll('.delete-product-form').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            selectedDeleteForm = this;

            deleteModal.classList.remove('hidden');
            deleteModal.classList.add('flex');

            document.body.style.overflow = 'hidden';
        });
    });

    // Menutup modal
    function hideDeleteModal() {
        deleteModal.classList.add('hidden');
        deleteModal.classList.remove('flex');

        document.body.style.overflow = '';

        selectedDeleteForm = null;
    }

    // Tombol Batal dan X
    cancelDelete.addEventListener('click', hideDeleteModal);
    closeDeleteModal.addEventListener('click', hideDeleteModal);

    // Klik area luar modal
    deleteModal.addEventListener('click', function(event) {
        if (event.target === deleteModal) {
            hideDeleteModal();
        }
    });

    // Tombol Escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && !deleteModal.classList.contains('hidden')) {
            hideDeleteModal();
        }
    });

    // Konfirmasi hapus
    confirmDelete.addEventListener('click', function() {
        if (selectedDeleteForm) {
            selectedDeleteForm.submit();
        }
    });
</script>

</body>
</html>
