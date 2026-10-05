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
        <x-sidebar active="dashboard" />

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