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
                                        <img src="{{ $product->image_url }}" class="w-10 h-10 object-cover rounded-lg">
                                    @else
                                        <span class="text-xs text-gray-400 italic">No image</span>
                                    @endif
                                </td>
                                <td class="p-4 font-semibold text-gray-800">{{ $product->name }}</td>
                                <td class="p-4">
                                    <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 text-xs rounded-full font-medium">
                                        {{ $product->user->name ?? 'Anonim' }}
                                    </span>
                                </td>
                                <td class="p-4 text-gray-600">{{ $product->condition }}</td>
                                <td class="p-4 text-emerald-600 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="p-4 text-center space-x-2">
                                    <button onclick="openEditModal({{ $product->id }})" class="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 font-medium text-xs transition">Edit</button>
                                    
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah kamu yakin ingin menghapus barang ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 font-medium text-xs transition">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-6 text-center text-gray-400">Belum ada data barang.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </main>
    </div>

    <!-- MODAL FORM (TAMBAH / EDIT BARANG) -->
    <div id="productModal" class="fixed inset-0 bg-gray-900/50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-emerald-900 text-white">
                <h3 id="modalTitle" class="font-bold text-lg">Tambah Barang Baru</h3>
                <button onclick="closeModal()" class="text-white/80 hover:text-white text-xl font-bold">&times;</button>
            </div>
            <form id="productForm" method="POST" class="p-5 space-y-4">
                @csrf
                <input type="hidden" id="methodField" name="_method" value="POST">

                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Nama Barang</label>
                    <input type="text" id="name" name="name" required class="w-full px-4 py-2 border rounded-xl text-sm focus:outline-emerald-600">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Harga (Rp)</label>
                    <input type="number" id="price" name="price" required class="w-full px-4 py-2 border rounded-xl text-sm focus:outline-emerald-600">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Kondisi</label>
                    <select id="condition" name="condition" class="w-full px-4 py-2 border rounded-xl text-sm focus:outline-emerald-600">
                        <option value="Sangat Baik">Sangat Baik</option>
                        <option value="Baik">Baik</option>
                        <option value="Layak Pakai">Layak Pakai</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">URL Gambar (Opsional)</label>
                    <input type="url" id="image_url" name="image_url" placeholder="https://..." class="w-full px-4 py-2 border rounded-xl text-sm focus:outline-emerald-600">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Deskripsi Barang</label>
                    <textarea id="description" name="description" rows="3" class="w-full px-4 py-2 border rounded-xl text-sm focus:outline-emerald-600"></textarea>
                </div>

                <div class="flex justify-end space-x-2 pt-2">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-xl">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('productModal');
        const form = document.getElementById('productForm');
        const modalTitle = document.getElementById('modalTitle');
        const methodField = document.getElementById('methodField');

        function openCreateModal() {
            modalTitle.innerText = "Tambah Barang Baru";
            form.action = "{{ route('products.store') }}";
            methodField.value = "POST";
            form.reset();
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
                    document.getElementById('condition').value = data.condition;
                    document.getElementById('image_url').value = data.image_url ?? '';
                    document.getElementById('description').value = data.description ?? '';

                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                });
        }

        function closeModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</body>
</html>