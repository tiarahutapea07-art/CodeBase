
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang - ReUseMarket</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-slate-50 font-sans min-h-screen">

<!-- Header ReUseMarket -->
<header class="sticky top-0 z-50 bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-[1440px] mx-auto px-5 py-4">
        <div class="flex items-center justify-between">

            <!-- Logo -->
            <a href="{{ route('home') }}"
               class="text-2xl font-extrabold tracking-tight whitespace-nowrap">
                <span class="text-emerald-600">Re</span><span class="text-gray-900">UseMarket</span>
            </a>

            <!-- Tombol Kembali -->
            <a href="{{ route('home') }}"
               class="flex items-center gap-2 px-4 py-2.5 rounded-xl
                      border border-gray-300 text-gray-700
                      hover:border-emerald-500 hover:text-emerald-600
                      transition text-sm font-semibold">

                <svg class="w-4 h-4" fill="none"
                     stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M15 19l-7-7 7-7"/>
                </svg>

                Kembali ke Beranda
            </a>

        </div>
    </div>
</header>

<!-- Area Form Tambah Barang -->
<main
    data-url-kembali="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('home') }}"
    ondblclick="tutupFormTambahBarang(this)"
    class="flex items-center justify-center min-h-[calc(100vh-73px)] p-4">
    <!-- Modal Box Utama -->
     <div
        onclick="event.stopPropagation()"
        ondblclick="event.stopPropagation()"
        class="bg-white w-full max-w-xl rounded-2xl shadow-2xl overflow-hidden border border-slate-200">

        <!-- Header Modal -->
        <div class="bg-emerald-900 px-6 py-4 flex items-center justify-between text-white">
            <h3 class="font-bold text-sm tracking-wide">
                Tambah Barang Baru
            </h3>

            <a href="{{ auth()->user()->role === 'admin'
                ? route('admin.dashboard')
                : route('home') }}"
                class="text-emerald-200 hover:text-white text-lg font-bold">
                &times;
            </a>
        </div>

        <!-- Form Konten -->
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data"
              class="p-6 space-y-4 max-h-[80vh] overflow-y-auto">

            @csrf

        <!-- Pilihan Jenis Barang -->
        <div id="pilihan-jenis">
            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-2">
                Pilih Jenis Barang
            </label>

            <div class="grid grid-cols-2 gap-3">

                <!-- Card Jual -->
                <label class="cursor-pointer">
                    <input type="radio" name="type" value="jual"
                        class="peer hidden" onchange="aturForm()">

                    <div class="border border-slate-300 rounded-xl p-4 text-center
                                hover:border-emerald-500 transition
                                peer-checked:border-emerald-600 peer-checked:bg-emerald-50">

                        <div class="text-2xl mb-2">🛍️</div>
                        <h4 class="text-sm font-bold text-slate-700">Jual Barang</h4>
                        <p class="text-[10px] text-slate-500 mt-1">
                            Jual barang preloved Anda
                        </p>
                    </div>
                </label>

                <!-- Card Donasi -->
                <label class="cursor-pointer">
                    <input type="radio" name="type" value="donasi"
                        class="peer hidden" onchange="aturForm()">

                    <div class="border border-slate-300 rounded-xl p-4 text-center
                                hover:border-emerald-500 transition
                                peer-checked:border-emerald-600 peer-checked:bg-emerald-50">

                        <div class="text-2xl mb-2">💚</div>
                        <h4 class="text-sm font-bold text-slate-700">Donasikan Barang</h4>
                        <p class="text-[10px] text-slate-500 mt-1">
                            Berikan barang secara gratis
                        </p>
                    </div>
                </label>

            </div>
        </div>

        <!-- Jenis Barang yang Dipilih -->
        <div id="jenis-terpilih" class="hidden flex items-center justify-between bg-emerald-50 border border-emerald-200 rounded-xl px-4 py-3">

            <div>
                <p class="text-[10px] font-bold text-slate-500 uppercase">
                    Jenis Barang
                </p>
                <p id="nama-jenis" class="text-sm font-bold text-emerald-800"></p>
            </div>

            <button type="button" onclick="ubahPilihan()"
                    class="text-xs font-bold text-emerald-700 hover:text-emerald-900">
                Ubah Pilihan
            </button>

        </div>

            <!-- Form Detail Barang -->
            <div id="form-detail" class="hidden space-y-4">

                <!-- Nama Barang -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Nama Barang
                    </label>

                    <input type="text" name="name" required value="{{ old('name') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-600 text-sm">
                </div>

                <!-- Kategori -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Kategori
                    </label>

                    <select name="category_id" required
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-600 text-sm bg-white">

                        <option value="">Pilih Kategori</option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Harga Barang -->
                <div id="bagian-harga">
                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Harga (Rp)
                    </label>

                    <input type="number" name="price" id="price"
                           min="1" value="{{ old('price') }}"
                           placeholder="Contoh: 250000"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-600 text-sm">
                </div>

                <!-- Harga Donasi -->
                <div id="bagian-gratis" class="hidden">
                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Harga
                    </label>

                    <div class="w-full px-4 py-2.5 rounded-xl border border-emerald-200 bg-emerald-50 text-emerald-700 text-sm font-bold">
                        GRATIS
                    </div>
                </div>

                <!-- Kondisi -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Kondisi
                    </label>

                    <select name="condition" required
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-600 text-sm bg-white">

                        <option value="Sangat Baik">Sangat Baik</option>
                        <option value="Baik">Baik</option>
                        <option value="Cukup">Cukup</option>
                    </select>
                </div>

                <!-- Foto Barang -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Foto / URL Gambar (Opsi)
                    </label>

                    <input type="file" name="image" accept="image/*"
                           class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                </div>

                <!-- Deskripsi Barang -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Deskripsi Barang
                    </label>

                    <textarea name="description" rows="3"
                              class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-600 text-sm"
                              placeholder="Jelaskan detail barang preloved Anda...">{{ old('description') }}</textarea>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                   <a href="{{ auth()->user()->role === 'admin'
                        ? route('admin.dashboard')
                        : route('home') }}">
                        Batal
                    </a>

                    <button type="submit"
                            class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-md transition">
                        Simpan Data
                    </button>
                </div>

            </div>
        </form>
    </div>

    <!-- Pengaturan Form -->
    <script>
        function tutupFormTambahBarang(area) {
            const urlKembali = area.getAttribute('data-url-kembali');

            if (urlKembali) {
                window.location.href = urlKembali;
            }
        }
        function aturForm() {
        const pilihan = document.querySelector('input[name="type"]:checked');
        const jenis = pilihan ? pilihan.value : '';

        const pilihanJenis = document.getElementById('pilihan-jenis');
        const jenisTerpilih = document.getElementById('jenis-terpilih');
        const namaJenis = document.getElementById('nama-jenis');

        const formDetail = document.getElementById('form-detail');
        const bagianHarga = document.getElementById('bagian-harga');
        const bagianGratis = document.getElementById('bagian-gratis');
        const harga = document.getElementById('price');

        if (jenis === '') {
            pilihanJenis.classList.remove('hidden');
            jenisTerpilih.classList.add('hidden');
            formDetail.classList.add('hidden');
            return;
        }

        pilihanJenis.classList.add('hidden');
        jenisTerpilih.classList.remove('hidden');
        formDetail.classList.remove('hidden');

        namaJenis.textContent = jenis === 'jual'
            ? 'Jual Barang'
            : 'Donasikan Barang';

        if (jenis === 'donasi') {
            bagianHarga.classList.add('hidden');
            bagianGratis.classList.remove('hidden');
            harga.required = false;
            harga.value = '';
        } else {
            bagianHarga.classList.remove('hidden');
            bagianGratis.classList.add('hidden');
            harga.required = true;
        }
    }

    function ubahPilihan() {
        document.querySelectorAll('input[name="type"]').forEach(input => {
            input.checked = false;
        });

        aturForm();
    }

    aturForm();
    </script>

</body>
</html>
