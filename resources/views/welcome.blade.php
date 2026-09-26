<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ReUseMarket - Thrift & Preloved Store</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

    <!-- ================= NAVBAR ================= -->
    <header class="bg-white/90 backdrop-blur-md border-b border-gray-200 sticky top-0 z-50">

        <div class="max-w-7xl mx-auto px-6 py-4">

            <div class="flex items-center justify-between">

                <!-- Logo -->
                <a href="#" class="text-2xl font-extrabold tracking-tight">
                    <span class="text-emerald-600">Re</span><span class="text-gray-900">UseMarket</span>
                </a>


                <!-- Navigation -->
                <nav class="hidden md:flex items-center gap-10 text-base font-medium">

                    <a href="#"
                       class="text-gray-600 hover:text-emerald-600 transition">
                        Jelajahi
                    </a>

                    <a href="#kategori"
                       class="text-gray-600 hover:text-emerald-600 transition">
                        Kategori
                    </a>

                    <a href="#penjual"
                       class="text-gray-600 hover:text-emerald-600 transition">
                        Penjual
                    </a>

                    <a href="#blog"
                       class="text-gray-600 hover:text-emerald-600 transition">
                        Blog
                    </a>

                </nav>


<!-- Right Navigation -->
                <div class="hidden md:flex items-center gap-8">

                    <!-- Search -->
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5 absolute left-3 top-1/2
                        -translate-y-1/2 text-gray-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="m21 21-4.35-4.35m2.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/></svg>
                        
                        <input
                        type="text"
                        id="searchInput"
                        placeholder="Cari..."
                        class="w-36 bg-gray-100
                            border border-gray-200
                            rounded-full
                            text-gray-800 text-sm
                            pl-10 pr-3 py-1.5
                            outline-none
                            focus:border-emerald-500 focus:bg-white
                            transition">
                    </div>


                    <!-- Admin (TAMBAHAN TOMBOL DASHBOARD) -->
                    <a href="{{ route('dashboard') }}"
                       class="text-emerald-700 bg-emerald-50 border border-emerald-200 
                              hover:bg-emerald-600 hover:text-white 
                              font-semibold px-4 py-2 rounded-xl transition">
                        Admin
                    </a>


                    <!-- Masuk -->
                    <a href="#"
                       class="text-gray-600 hover:text-gray-900 transition font-medium">
                        Masuk
                    </a>


                    <!-- Jual -->
                    <a href="#"
                       class="bg-emerald-600 hover:bg-emerald-700
                              text-white font-bold
                              px-6 py-2.5 rounded-xl shadow-sm hover:shadow
                              transition">
                        + Jual
                    </a>

                </div>

            </div>

        </div>

    </header>

    <!-- ================= HERO ================= -->
    <section class="relative overflow-hidden bg-amber-50/50">

        <!-- Background -->
        <div
            class="absolute inset-0 bg-cover bg-center opacity-15"
            style="background-image: url('https://images.unsplash.com/photo-1523381210434-271e8be1f52b?q=80&w=1800&auto=format&fit=crop');">
        </div>

        <!-- Overlay Gradient Cerah -->
        <div class="absolute inset-0 bg-gradient-to-r
                    from-amber-50 via-amber-50/90
                    to-transparent">
        </div>

        <!-- Hero Content -->
        <div class="relative max-w-7xl mx-auto px-6">

            <div class="min-h-[480px] flex items-center">

                <div class="max-w-xl">

                    <p class="text-amber-700 font-bold tracking-[0.25em]
                              text-sm mb-4 uppercase">
                        SECONDHAND MARKETPLACE
                    </p>

                    <h1 class="text-5xl md:text-6xl font-black
                               leading-tight tracking-tight text-gray-900">

                        <span class="text-emerald-600">RE</span><span class="text-amber-600">USE</span>
                        <br>
                        <span class="text-gray-900">MARKET</span>

                    </h1>

                    <p class="text-gray-600 text-lg md:text-xl
                              mt-5 max-w-lg leading-relaxed">

                        Platform jual beli barang bekas berkualitas.
                        Temukan barang preloved terbaik dengan harga terjangkau.

                    </p>

                    <a
                        href="#katalog"
                        class="inline-flex items-center gap-2
                               mt-8
                               bg-amber-500 hover:bg-amber-600
                               text-white font-bold
                               px-7 py-3.5
                               rounded-full shadow-md hover:shadow-lg
                               transition duration-300
                               hover:scale-105">

                        Jelajahi Sekarang

                        <span class="text-lg">→</span>

                    </a>

                </div>

            </div>

        </div>

    </section>


    <!-- ================= SEARCH & CATEGORY ================= -->
    <section id="kategori"
             class="bg-gray-50 px-6 pt-12 pb-4">

        <div class="max-w-4xl mx-auto">

            <!-- Search -->
            <div class="relative shadow-sm rounded-full">

                <input
                    type="text"
                    id="searchProduct"
                    placeholder="Cari barang yang kamu butuhkan..."
                    class="w-full
                           bg-white
                           border border-gray-300
                           rounded-full
                           px-6 py-4 pl-14
                           text-gray-800
                           placeholder-gray-400
                           focus:outline-none
                           focus:border-amber-500 focus:ring-2 focus:ring-amber-200
                           transition"
                >

                <!-- Search Icon -->
                <svg
                    class="absolute left-5 top-4 w-6 h-6 text-gray-400"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z"
                    />
                </svg>

            </div>


            <!-- Category Buttons -->
            <div class="flex flex-wrap justify-center gap-3 mt-6">

                <button
                    data-category="all"
                    class="category-btn active-category
                           px-6 py-2.5 rounded-full
                           bg-amber-500 text-white
                           font-semibold text-sm shadow-sm
                           transition">

                    ⊞ &nbsp; Semua

                </button>

                <button
                    data-category="fashion"
                    class="category-btn
                           px-6 py-2.5 rounded-full
                           bg-white border border-gray-300
                           text-gray-700 hover:bg-gray-50
                           hover:border-amber-500
                           hover:text-amber-600
                           transition">

                    ♧ &nbsp; Fashion

                </button>

                <button
                    data-category="elektronik"
                    class="category-btn
                           px-6 py-2.5 rounded-full
                           bg-white border border-gray-300
                           text-gray-700 hover:bg-gray-50
                           hover:border-amber-500
                           hover:text-amber-600
                           transition">

                    ▣ &nbsp; Elektronik

                </button>

                <button
                    data-category="buku"
                    class="category-btn
                           px-6 py-2.5 rounded-full
                           bg-white border border-gray-300
                           text-gray-700 hover:bg-gray-50
                           hover:border-amber-500
                           hover:text-amber-600
                           transition">

                    ▤ &nbsp; Buku

                </button>

                <button
                    data-category="furniture"
                    class="category-btn
                           px-6 py-2.5 rounded-full
                           bg-white border border-gray-300
                           text-gray-700 hover:bg-gray-50
                           hover:border-amber-500
                           hover:text-amber-600
                           transition">

                    ▱ &nbsp; Furniture

                </button>

                <button
                    data-category="lainnya"
                    class="category-btn
                           px-6 py-2.5 rounded-full
                           bg-white border border-gray-300
                           text-gray-700 hover:bg-gray-50
                           hover:border-amber-500
                           hover:text-amber-600
                           transition">

                    ••• &nbsp; Lainnya

                </button>

            </div>

        </div>

    </section>


    <!-- ================= KATALOG ================= -->
    <main id="katalog"
          class="max-w-7xl mx-auto px-6 py-10">

        <!-- Catalog Header -->
        <div class="flex flex-col md:flex-row
                    md:items-end md:justify-between
                    gap-4 mb-8">

            <div>

                <p class="text-amber-600
                          text-sm font-bold
                          tracking-[0.2em] uppercase">

                    Explore

                </p>

                <h2 class="text-3xl font-extrabold
                           text-gray-900 mt-1">

                    Katalog Barang Bekas Terbaru

                </h2>

                <p class="text-gray-600 mt-1">

                    Temukan barang preloved berkualitas
                    dengan harga terjangkau.

                </p>

            </div>

            <p class="text-sm text-gray-500">

                Menampilkan
                <span id="productCount"
                      class="text-amber-600 font-bold">
                    {{ $products->count() }}
                </span>
                barang

            </p>

        </div>


        <!-- Product Grid -->
        <div
            id="productGrid"
            class="grid grid-cols-1 sm:grid-cols-2
                   lg:grid-cols-4 gap-6">

            @foreach($products as $product)

                <div
                    class="product-card group
                           bg-white
                           border border-gray-200
                           rounded-2xl
                           overflow-hidden shadow-sm hover:shadow-md
                           hover:border-amber-400
                           hover:-translate-y-1
                           transition-all duration-300"

                    data-product-name="{{ strtolower($product->name) }}"
                    data-product-description="{{ strtolower($product->description) }}"
                    data-product-condition="{{ strtolower($product->condition) }}"
                >

                    <!-- Image -->
                    <div class="relative overflow-hidden bg-gray-100">

                        <img
                            src="{{ $product->image_url }}"
                            alt="{{ $product->name }}"
                            class="w-full h-56
                                   object-cover
                                   group-hover:scale-105
                                   transition duration-500"
                        >

                        <!-- Preloved Badge -->
                        <span
                            class="absolute top-3 left-3
                                   bg-amber-500
                                   text-white
                                   text-[11px]
                                   font-bold
                                   px-3 py-1
                                   rounded-full shadow">

                            PRELOVED

                        </span>

                        <!-- Favorite -->
                        <button
                            class="absolute top-3 right-3
                                   w-9 h-9
                                   rounded-full
                                   bg-white/80
                                   backdrop-blur-sm
                                   flex items-center justify-center
                                   text-gray-600
                                   hover:text-red-500 hover:bg-white
                                   transition shadow-sm">

                            ♡

                        </button>

                    </div>


                    <!-- Product Info -->
                    <div class="p-5">

                        <!-- Condition -->
                        <span
                            class="inline-block
                                   text-[11px]
                                   font-semibold
                                   bg-amber-100
                                   text-amber-800
                                   px-2.5 py-1
                                   rounded-full">

                            Kondisi: {{ $product->condition }}

                        </span>


                        <!-- Name -->
                        <h3
                            class="text-base font-bold
                                   text-gray-900
                                   mt-3
                                   group-hover:text-amber-600
                                   transition">

                            {{ $product->name }}

                        </h3>


                        <!-- Description -->
                        <p
                            class="text-gray-500
                                   text-xs
                                   mt-2
                                   line-clamp-2">

                            {{ $product->description }}

                        </p>


                        <!-- Price + Button -->
                        <div
                            class="flex items-end
                                   justify-between
                                   gap-2
                                   mt-5 pt-3 border-t border-gray-100">

                            <div>

                                <p class="text-[10px]
                                          text-gray-400
                                          uppercase font-semibold
                                          mb-0.5">

                                    Harga

                                </p>

                                <p
                                    class="text-amber-600
                                           font-extrabold
                                           text-lg">

                                    Rp {{ number_format($product->price, 0, ',', '.') }}

                                </p>

                            </div>


                            <button
                                class="border border-amber-500
                                       text-amber-600 hover:bg-amber-500
                                       hover:text-white
                                       font-bold
                                       text-xs
                                       px-3.5 py-2
                                       rounded-full
                                       transition">

                                Lihat Detail

                            </button>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>


        <!-- Empty Search -->
        <div
            id="emptyMessage"
            class="hidden text-center py-20">

            <div class="text-5xl mb-4">
                🔍
            </div>

            <h3 class="text-xl font-bold text-gray-800">
                Barang tidak ditemukan
            </h3>

            <p class="text-gray-500 mt-2">
                Coba gunakan kata kunci yang berbeda.
            </p>

        </div>

    </main>


    <!-- ================= ABOUT ================= -->
    <section id="tentang"
             class="border-t border-gray-200
                    bg-white">

        <div class="max-w-7xl mx-auto
                    px-6 py-16">

            <div class="max-w-2xl">

                <p class="text-amber-600
                          text-sm font-bold
                          tracking-[0.2em] uppercase">

                    Tentang Kami

                </p>

                <h2 class="text-3xl
                           font-extrabold
                           text-gray-900 mt-2">

                    Barang Lama, Cerita Baru.

                </h2>

                <p class="text-gray-600
                          mt-4 leading-relaxed">

                    ReUseMarket merupakan platform jual beli barang
                    bekas dan preloved yang membantu pengguna menemukan
                    barang berkualitas dengan harga yang lebih terjangkau.

                    Kami percaya bahwa barang yang sudah pernah digunakan
                    masih bisa memiliki nilai dan cerita baru.

                </p>

            </div>

        </div>

    </section>


    <!-- ================= FOOTER ================= -->
    <footer id="kontak"
            class="bg-gray-100
                   border-t border-gray-200">

        <div class="max-w-7xl mx-auto
                    px-6 py-12">

            <div class="grid grid-cols-1
                        md:grid-cols-3
                        gap-8">

                <!-- Brand -->
                <div>

                    <h3 class="text-xl font-extrabold">

                        <span class="text-emerald-600">Re</span><span class="text-amber-600">Use</span><span class="text-gray-900">Market</span>

                    </h3>

                    <p class="text-gray-500
                              text-sm mt-2">

                        Barang bekas, peluang baru.

                    </p>

                </div>


                <!-- Navigation -->
                <div>

                    <h4 class="text-gray-900 font-semibold mb-3">
                        Navigasi
                    </h4>

                    <div class="flex flex-col gap-2
                                text-sm text-gray-600">

                        <a href="#"
                           class="hover:text-amber-600 transition">
                            Beranda
                        </a>

                        <a href="#kategori"
                           class="hover:text-amber-600 transition">
                            Kategori
                        </a>

                        <a href="#tentang"
                           class="hover:text-amber-600 transition">
                            Tentang Kami
                        </a>

                    </div>

                </div>


                <!-- Contact -->
                <div>

                    <h4 class="text-gray-900 font-semibold mb-3">
                        Kontak
                    </h4>

                    <p class="text-gray-600 text-sm">
                        Email: reusemarket@gmail.com
                    </p>

                    <p class="text-gray-600 text-sm mt-2">
                        Instagram: @reusemarket
                    </p>

                </div>

            </div>


            <!-- Copyright -->
            <div
                class="border-t border-gray-200
                       mt-10 pt-6
                       flex flex-col md:flex-row
                       justify-between
                       gap-3
                       text-xs text-gray-500">

                <p>
                    © 2025 ReUseMarket.
                    All rights reserved.
                </p>

                <p>
                    Platform Thrift & Preloved Online
                </p>

            </div>

        </div>

    </footer>


    <!-- ================= SEARCH & FILTER SCRIPT ================= -->
    <script>

        const searchInput =
            document.getElementById('searchProduct');

        const productCards =
            document.querySelectorAll('.product-card');

        const productCount =
            document.getElementById('productCount');

        const emptyMessage =
            document.getElementById('emptyMessage');

        const categoryButtons =
            document.querySelectorAll('.category-btn');

        let selectedCategory = 'all';


        function filterProducts() {

            const keyword =
                searchInput.value.toLowerCase().trim();

            let visibleProducts = 0;


            productCards.forEach(card => {

                const name =
                    card.dataset.productName;

                const description =
                    card.dataset.productDescription;

                const condition =
                    card.dataset.productCondition;


                const text =
                    `${name} ${description} ${condition}`;


                let categoryMatch = true;


                if (selectedCategory !== 'all') {

                    if (selectedCategory === 'fashion') {

                        categoryMatch =
                            /baju|kaos|kemeja|jaket|hoodie|celana|sepatu|tas|fashion/.test(text);

                    } else if (selectedCategory === 'elektronik') {

                        categoryMatch =
                            /laptop|hp|handphone|smartphone|kamera|earphone|headset|elektronik/.test(text);

                    } else if (selectedCategory === 'buku') {

                        categoryMatch =
                            /buku|novel|komik|majalah/.test(text);

                    } else if (selectedCategory === 'furniture') {

                        categoryMatch =
                            /kursi|meja|lemari|rak|sofa|furniture/.test(text);

                    } else if (selectedCategory === 'lainnya') {

                        categoryMatch =
                            !/baju|kaos|kemeja|jaket|hoodie|celana|sepatu|tas|fashion|laptop|hp|handphone|smartphone|kamera|earphone|headset|elektronik|buku|novel|komik|majalah|kursi|meja|lemari|rak|sofa|furniture/.test(text);

                    }

                }


                const searchMatch =
                    text.includes(keyword);


                if (categoryMatch && searchMatch) {

                    card.classList.remove('hidden');

                    visibleProducts++;

                } else {

                    card.classList.add('hidden');

                }

            });


            productCount.textContent =
                visibleProducts;


            if (visibleProducts === 0) {

                emptyMessage.classList.remove('hidden');

            } else {

                emptyMessage.classList.add('hidden');

            }

        }


        // Search
        searchInput.addEventListener(
            'input',
            filterProducts
        );


        // Category
        categoryButtons.forEach(button => {

            button.addEventListener('click', function () {

                selectedCategory =
                    this.dataset.category;


                // Reset semua button
                categoryButtons.forEach(btn => {

                    btn.classList.remove(
                        'active-category',
                        'bg-amber-500',
                        'text-white',
                        'shadow-sm'
                    );

                    btn.classList.add(
                        'bg-white',
                        'border',
                        'border-gray-300',
                        'text-gray-700'
                    );

                });


                // Aktifkan button
                this.classList.add(
                    'active-category',
                    'bg-amber-500',
                    'text-white',
                    'shadow-sm'
                );

                this.classList.remove(
                    'bg-white',
                    'border-gray-300',
                    'text-gray-700'
                );


                filterProducts();

            });

        });

    </script>

</body>
</html>