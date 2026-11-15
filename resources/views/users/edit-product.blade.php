
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang - ReUseMarket</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-emerald-50/30 min-h-screen text-gray-800">

    <!-- HEADER -->
    <header class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-6xl mx-auto px-5 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}"
               class="text-2xl font-extrabold tracking-tight">
                <span class="text-emerald-600">Re</span><span>UseMarket</span>
            </a>

            <a href="{{ route('my-products.index') }}"
               class="text-sm font-semibold text-emerald-700 hover:text-emerald-900">
                ← Kembali ke Barang Saya
            </a>
        </div>
    </header>

    <!-- CONTENT -->
    <main class="max-w-3xl mx-auto px-4 py-10">

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">

            <div class="bg-emerald-600 px-6 py-5 text-white">
                <h1 class="text-2xl font-bold">Edit Barang</h1>
                <p class="text-emerald-50 text-sm mt-1">
                    Perbarui informasi dan foto barang kamu.
                </p>
            </div>

            <form action="{{ url('/barang-saya/' . $product->id) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="p-6 space-y-5">

                @csrf
                @method('PUT')

                <!-- NAMA BARANG -->
                <div>
                    <label class="block font-semibold mb-2">Nama Barang</label>
                    <input type="text"
                           name="name"
                           value="{{ old('name', $product->name) }}"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 outline-none">

                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- JENIS BARANG -->
                <div>
                    <label class="block font-semibold mb-2">Jenis Barang</label>
                    <select name="type" id="type"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 outline-none">
                        <option value="jual"
                            {{ old('type', $product->price > 0 ? 'jual' : 'donasi') == 'jual' ? 'selected' : '' }}>
                            Dijual
                        </option>
                        <option value="donasi"
                            {{ old('type', $product->price > 0 ? 'jual' : 'donasi') == 'donasi' ? 'selected' : '' }}>
                            Donasi
                        </option>
                    </select>

                    @error('type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- KATEGORI -->
                <div>
                    <label class="block font-semibold mb-2">Kategori</label>
                    <select name="category_id"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 outline-none">
                        <option value="">Pilih Kategori</option>

                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('category_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- HARGA -->
                <div id="price-wrapper">
                    <label class="block font-semibold mb-2">Harga (Rp)</label>
                    <input type="number"
                           name="price"
                           id="price"
                           min="1"
                           value="{{ old('price', $product->price) }}"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 outline-none">

                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- KONDISI -->
                <div>
                    <label class="block font-semibold mb-2">Kondisi Barang</label>
                    <input type="text"
                           name="condition"
                           value="{{ old('condition', $product->condition) }}"
                           placeholder="Contoh: Baik, Cukup, Ada Lecet"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 outline-none">

                    @error('condition')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- DESKRIPSI -->
                <div>
                    <label class="block font-semibold mb-2">Deskripsi Barang</label>
                    <textarea name="description"
                              rows="4"
                              class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 outline-none"
                              placeholder="Jelaskan kondisi dan detail barang...">{{ old('description', $product->description) }}</textarea>

                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- FOTO LAMA -->
                <div>
                    <label class="block font-semibold mb-2">Foto Saat Ini</label>

                    @if($product->image_url)
                        @php
                            $imagePath = $product->image_url;

                            if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
                                $imageSrc = $imagePath;
                            } elseif (str_starts_with($imagePath, 'images/')) {
                                $imageSrc = asset($imagePath);
                            } else {
                                $imageSrc = asset('storage/' . $imagePath);
                            }
                        @endphp

                        <img src="{{ $imageSrc }}"
                             alt="Foto barang"
                             class="w-40 h-40 object-cover rounded-xl border border-gray-200">
                    @else
                        <p class="text-gray-500 text-sm">Belum ada foto barang.</p>
                    @endif
                </div>

                <!-- FOTO BARU -->
                <div>
                    <label class="block font-semibold mb-2">
                        Ganti / Tambahkan Foto Barang
                    </label>

                    <input type="file"
                           name="image"
                           accept="image/jpeg,image/png,image/webp"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3">

                    <p class="text-gray-500 text-xs mt-2">
                        Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                        Kosongkan jika tidak ingin mengganti foto lama.
                    </p>

                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- TOMBOL -->
                <div class="flex flex-col sm:flex-row gap-3 pt-4">
                    <a href="{{ route('my-products.index') }}"
                       class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 rounded-xl">
                        Batal
                    </a>

                    <button type="submit"
                            class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 rounded-xl">
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </main>

    <script>
        const typeSelect = document.getElementById('type');
        const priceWrapper = document.getElementById('price-wrapper');
        const priceInput = document.getElementById('price');

        function togglePrice() {
            if (typeSelect.value === 'donasi') {
                priceWrapper.style.display = 'none';
                priceInput.value = 0;
            } else {
                priceWrapper.style.display = 'block';

                if (Number(priceInput.value) === 0) {
                    priceInput.value = '';
                }
            }
        }

        typeSelect.addEventListener('change', togglePrice);
        togglePrice();
    </script>

</body>
</html>
