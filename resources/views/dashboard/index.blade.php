<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ReUseMarket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-emerald-50/30 text-gray-800">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar Navigation -->
        <aside class="w-64 bg-emerald-900 text-white flex flex-col justify-between p-5 shadow-lg">
            <div>
                <div class="mb-8 px-2">
                    <a href="{{ route('home') }}" class="block group">
                        <span class="block text-2xl font-black text-white tracking-wider leading-none">ReUse</span>
                        <span class="block text-xl font-extrabold text-emerald-400 tracking-widest uppercase leading-tight group-hover:text-emerald-300 transition">Market</span>
                    </a>
                </div>

                <nav class="space-y-1.5">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl bg-emerald-700/60 text-emerald-100 font-medium transition">
                        <svg class="w-5 h-5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('products.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-emerald-800/50 text-emerald-200/80 hover:text-white transition">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        <span>Data Barang</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-emerald-800/50 text-emerald-200/80 hover:text-white transition">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        <span>Barang Masuk</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-emerald-800/50 text-emerald-200/80 hover:text-white transition">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span>Barang Keluar</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-emerald-800/50 text-emerald-200/80 hover:text-white transition">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span>Pengguna / User</span>
                    </a>
                </nav>
            </div>

            <div class="space-y-4">
                <div class="pt-4 border-t border-emerald-800/60">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl bg-emerald-800/40 border border-emerald-700/50 hover:bg-emerald-800/80 text-emerald-200 hover:text-white transition">
                        <svg class="w-5 h-5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span class="text-sm font-medium">Lihat Marketplace</span>
                    </a>
                </div>
                <div class="px-2">
                    <div class="text-[11px] text-emerald-400 font-medium uppercase tracking-wider">Pengguna Aktif</div>
                    <div class="text-sm font-semibold text-white truncate">Admin ReUseMarket</div>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 p-8 overflow-y-auto">
            
            <header class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Ringkasan Aktivitas</h2>
                    <p class="text-sm text-gray-500">Pantau pergerakan barang bekas dan aktivitas user.</p>
                </div>
                <a href="{{ route('products.index') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl font-medium shadow-sm transition">
                    Kelola Data Barang &rarr;
                </a>
            </header>

            <!-- Card Ringkasan Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-emerald-100">
                    <span class="text-xs font-semibold text-gray-400 uppercase">Total Barang</span>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalProducts }}</p>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-emerald-100">
                    <span class="text-xs font-semibold text-gray-400 uppercase">Barang Masuk (Bulan Ini)</span>
                    <p class="text-2xl font-bold text-emerald-600 mt-1">+12 Item</p>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-emerald-100">
                    <span class="text-xs font-semibold text-gray-400 uppercase">Barang Terjual / Keluar</span>
                    <p class="text-2xl font-bold text-blue-600 mt-1">8 Item</p>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-emerald-100">
                    <span class="text-xs font-semibold text-gray-400 uppercase">Total Estimasi Nilai</span>
                    <p class="text-2xl font-bold text-emerald-700 mt-1">Rp {{ number_format($totalValue, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Grafik -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-emerald-100 mb-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Statistik Pergerakan Barang</h3>
                <div class="h-64">
                    <canvas id="productChart"></canvas>
                </div>
            </div>

            <!-- Preview 5 Barang Terbaru -->
            <div class="bg-white rounded-2xl shadow-sm border border-emerald-100 overflow-hidden">
                <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">5 Barang Terbaru</h3>
                    <a href="{{ route('products.index') }}" class="text-emerald-600 text-sm font-semibold hover:underline">Lihat Semua Data &rarr;</a>
                </div>
                <table class="w-full text-left border-collapse">
                    <thead class="bg-emerald-50/50 text-xs uppercase font-semibold text-emerald-900">
                        <tr>
                            <th class="p-4">#</th>
                            <th class="p-4">Nama Barang</th>
                            <th class="p-4">Pemilik</th>
                            <th class="p-4">Kondisi</th>
                            <th class="p-4">Harga</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse ($products->take(5) as $product)
                            <tr class="hover:bg-emerald-50/20 transition">
                                <td class="p-4 text-gray-400">{{ $loop->iteration }}</td>
                                <td class="p-4 font-semibold text-gray-800">{{ $product->name }}</td>
                                <td class="p-4">{{ $product->user->name ?? 'Anonim' }}</td>
                                <td class="p-4 text-gray-600">{{ $product->condition }}</td>
                                <td class="p-4 text-emerald-600 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-6 text-center text-gray-400">Belum ada barang.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </main>
    </div>

    <script>
        const ctx = document.getElementById('productChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                datasets: [
                    {
                        label: 'Barang Masuk',
                        data: [12, 19, 15, 25, 22, 30],
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Barang Keluar',
                        data: [8, 11, 13, 18, 14, 20],
                        borderColor: '#3b82f6',
                        backgroundColor: 'transparent',
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top' }
                }
            }
        });
    </script>
</body>
</html>