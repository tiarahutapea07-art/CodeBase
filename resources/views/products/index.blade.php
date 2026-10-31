<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang - ReUseMarket</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-emerald-50/30 text-gray-800">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar Navigation -->
        <x-sidebar active="products" />

        <!-- Main Content Area -->
        <main class="flex-1 p-8 overflow-y-auto">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-100 border border-emerald-300 text-emerald-800 rounded-xl flex justify-between items-center">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="font-bold">&times;</button>
                </div>
            @endif

            <header class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Kelola Data Barang</h2>
                    <p class="text-sm text-gray-500">Tambah, ubah, dan hapus barang inventaris ReUseMarket.</p>
                </div>
                <button onclick="openCreateModal()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl font-medium shadow-sm transition">
                    + Tambah Barang Baru
                </button>
            </header>
            <!-- Filter Jenis Barang -->
            <div class="mb-5 flex items-center gap-3">
                <label for="filter" class="text-sm font-medium text-gray-700">
                    Filter Barang:
                </label>

                <form action="{{ route('products.index') }}" method="GET">
                    <select
                        name="filter"
                        id="filter"
                        onchange="this.form.submit()"
                        class="border border-emerald-200 rounded-xl px-4 py-2 text-sm bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    >
                        <option value="semua" {{ request('filter', 'semua') == 'semua' ? 'selected' : '' }}>
                            Semua Barang
                        </option>
                        <option value="jual" {{ request('filter') == 'jual' ? 'selected' : '' }}>
                            Barang Dijual
                        </option>
                        <option value="donasi" {{ request('filter') == 'donasi' ? 'selected' : '' }}>
                            Barang Donasi
                        </option>
                    </select>
                </form>
            </div>

            <!-- Tabel Data Barang -->
            <div class="bg-white rounded-2xl shadow-sm border border-emerald-100 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-emerald-50/50 text-xs uppercase font-semibold text-emerald-900">
                        <tr>
                            <th class="p-4">#</th>
                            <th class="p-4">Foto</th>
                            <th class="p-4">Nama Barang</th>
                            <th class="p-4">Pemilik / User</th>
                            <th class="p-4">Kondisi</th>
                            <th class="p-4">Harga</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse ($products as $product)
                            <tr class="hover:bg-emerald-50/20 transition">
                                <td class="p-4 text-gray-400">{{ $loop->iteration }}</td>

                                <td class="p-4">
                                    @if($product->image_url)
                                        <img
                                            src="{{ str_starts_with($product->image_url, 'products/')
                                                ? asset('storage/' . $product->image_url)
                                                : asset($product->image_url) }}"
                                            class="w-10 h-10 object-cover rounded-lg"
                                            alt="{{ $product->name }}"
                                        >
                                    @else
                                        <span class="text-xs text-gray-400 italic">No image</span>
                                    @endif
                                </td>

                                <td class="p-4 font-semibold text-gray-800">
                                    {{ $product->name }}
                                </td>

                                <td class="p-4">
                                    <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 text-xs rounded-full font-medium">
                                        {{ $product->user->name ?? 'Anonim' }}
                                    </span>
                                </td>

                                <!-- KONDISI -->
                                <td class="p-4 text-gray-600">
                                    {{ $product->condition }}
                                </td>

                                <!-- HARGA -->
                                <td class="p-4 font-bold">
                                    @if($product->price == 0)
                                        <span class="text-emerald-600">GRATIS</span>
                                    @else
                                        <span class="text-emerald-600">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </span>
                                    @endif
                                </td>

                                <!-- AKSI -->
                                <td class="p-4 text-center space-x-2">
                                    <button onclick="openEditModal({{ $product->id }})"
                                        class="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 font-medium text-xs transition">
                                        Edit
                                    </button>

                                    <form action="{{ route('products.destroy', $product->id) }}"
                                        method="POST"
                                        class="inline"
                                        onsubmit="return confirm('Apakah kamu yakin ingin menghapus barang ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 font-medium text-xs transition">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-6 text-center text-gray-400">
                                    Belum ada data barang.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </main>
    </div>

    
    <!-- MODAL FORM (TAMBAH / EDIT BARANG) -->
    <div id="productModal" class="fixed inset-0 bg-gray-900/50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden max-h-[90vh] overflow-y-auto">

            <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-emerald-900 text-white">
                <h3 id="modalTitle" class="font-bold text-lg">Tambah Barang Baru</h3>
                <button onclick="closeModal()" class="text-white/80 hover:text-white text-xl font-bold">&times;</button>
            </div>

            <form id="productForm" method="POST" enctype="multipart/form-data" class="p-5 space-y-4">
                @csrf
                <input type="hidden" id="methodField" name="_method" value="POST">

                <!-- JENIS BARANG -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">Jenis Barang</label>

                    <select id="type" name="type" onchange="aturHarga()" required
                        class="w-full px-4 py-2 border rounded-xl text-sm focus:outline-emerald-600">
                        <option value="jual">Jual Barang</option>
                        <option value="donasi">Donasikan Barang</option>
                    </select>
                </div>

                <!-- NAMA BARANG -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Nama Barang</label>
                    <input type="text" id="name" name="name" required
                        class="w-full px-4 py-2 border rounded-xl text-sm focus:outline-emerald-600">
                </div>

                <!-- KATEGORI -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Kategori</label>
                    <select id="category_id" name="category_id" required
                        class="w-full px-4 py-2 border rounded-xl text-sm focus:outline-emerald-600">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- HARGA JUAL -->
                <div id="bagian-harga">
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Harga (Rp)</label>
                    <input type="number" id="price" name="price" min="1"
                        class="w-full px-4 py-2 border rounded-xl text-sm focus:outline-emerald-600">
                </div>

                <!-- HARGA DONASI -->
                <div id="bagian-gratis" class="hidden">
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Harga Barang</label>
                    <div class="w-full px-4 py-2 border rounded-xl text-sm bg-emerald-50 text-emerald-700 font-bold">
                        GRATIS
                    </div>
                </div>

                <!-- KONDISI -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Kondisi</label>
                    <select id="condition" name="condition" required
                        class="w-full px-4 py-2 border rounded-xl text-sm focus:outline-emerald-600">
                        <option value="Sangat Baik">Sangat Baik</option>
                        <option value="Baik">Baik</option>
                        <option value="Layak Pakai">Layak Pakai</option>
                    </select>
                </div>

                <!-- FOTO -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Foto Barang</label>
                    <input type="file" id="image" name="image" accept="image/*"
                        class="w-full px-4 py-2 border rounded-xl text-sm">
                    <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengganti foto saat edit.</p>
                </div>

                <!-- DESKRIPSI -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Deskripsi Barang</label>
                    <textarea id="description" name="description" rows="3"
                        class="w-full px-4 py-2 border rounded-xl text-sm focus:outline-emerald-600"></textarea>
                </div>

                <div class="flex justify-end space-x-2 pt-2">
                    <button type="button" onclick="closeModal()"
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-xl">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        const modal = document.getElementById('productModal');
        const form = document.getElementById('productForm');
        const modalTitle = document.getElementById('modalTitle');
        const methodField = document.getElementById('methodField');

        function aturHarga() {
            const type = document.getElementById('type').value;
            const bagianHarga = document.getElementById('bagian-harga');
            const bagianGratis = document.getElementById('bagian-gratis');
            const price = document.getElementById('price');

            if (type === 'donasi') {
                bagianHarga.classList.add('hidden');
                bagianGratis.classList.remove('hidden');
                price.required = false;
                price.value = '';
            } else {
                bagianHarga.classList.remove('hidden');
                bagianGratis.classList.add('hidden');
                price.required = true;
            }
        }

        function openCreateModal() {
            modalTitle.innerText = "Tambah Barang Baru";
            form.action = "{{ route('products.store') }}";
            methodField.value = "POST";

            form.reset();

            document.getElementById('type').value = 'jual';
            aturHarga();

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function openEditModal(id) {
            fetch(`/products/${id}/edit`)
                .then(res => res.json())
                .then(data => {
                    modalTitle.innerText = "Edit Data Barang";
                    form.action = `/products/${id}`;
                    methodField.value = "PUT";

                    document.getElementById('name').value = data.name;
                    document.getElementById('price').value = data.price;
                    document.getElementById('category_id').value = data.category_id;
                    document.getElementById('condition').value = data.condition;
                    document.getElementById('description').value = data.description ?? '';

                    document.getElementById('type').value =
                        Number(data.price) === 0 ? 'donasi' : 'jual';

                    document.getElementById('image').value = '';

                    aturHarga();

                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                })
                .catch(error => {
                    alert('Gagal mengambil data barang.');
                    console.error(error);
                });
        }

        function closeModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</body>
</html>