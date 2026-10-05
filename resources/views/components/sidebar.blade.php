@props(['active' => ''])

<aside class="w-64 bg-emerald-900 text-white flex flex-col justify-between p-5 shadow-lg flex-shrink-0">
    <div>
        <!-- Logo ReUseMarket -->
        <div class="mb-8 px-2">
            <a href="{{ route('home') }}" class="block group">
                <span class="block text-2xl font-black text-white tracking-wider leading-none">ReUse</span>
                <span class="block text-xl font-extrabold text-emerald-400 tracking-widest uppercase leading-tight group-hover:text-emerald-300 transition">Market</span>
            </a>
        </div>

        <!-- Menu Navigasi -->
        <nav class="space-y-1.5">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-xl transition {{ $active === 'dashboard' ? 'bg-emerald-700/60 text-emerald-100 font-medium' : 'hover:bg-emerald-800/50 text-emerald-200/80 hover:text-white' }}">
                <svg class="w-5 h-5 {{ $active === 'dashboard' ? 'text-emerald-300' : 'text-emerald-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                <span>Dashboard</span>
            </a>

            <!-- Data Barang -->
            <a href="{{ route('products.index') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-xl transition {{ $active === 'products' ? 'bg-emerald-700/60 text-emerald-100 font-medium' : 'hover:bg-emerald-800/50 text-emerald-200/80 hover:text-white' }}">
                <svg class="w-5 h-5 {{ $active === 'products' ? 'text-emerald-300' : 'text-emerald-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <span>Data Barang</span>
            </a>

            <!-- Barang Masuk -->
            <a href="{{ route('incoming-goods.index') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-xl transition {{ $active === 'incoming-goods' ? 'bg-emerald-700/60 text-emerald-100 font-medium' : 'hover:bg-emerald-800/50 text-emerald-200/80 hover:text-white' }}">
                <svg class="w-5 h-5 {{ $active === 'incoming-goods' ? 'text-emerald-300' : 'text-emerald-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                </svg>
                <span>Barang Masuk</span>
            </a>

            <!-- Barang Keluar -->
            <a href="{{ route('outgoing-goods.index') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-xl transition {{ $active === 'outgoing-goods' ? 'bg-emerald-700/60 text-emerald-100 font-medium' : 'hover:bg-emerald-800/50 text-emerald-200/80 hover:text-white' }}">
                <svg class="w-5 h-5 {{ $active === 'outgoing-goods' ? 'text-emerald-300' : 'text-emerald-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span>Barang Keluar</span>
            </a>

            <!-- Pengguna / User -->
            <a href="{{ route('users.index') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-xl transition {{ $active === 'users' ? 'bg-emerald-700/60 text-emerald-100 font-medium' : 'hover:bg-emerald-800/50 text-emerald-200/80 hover:text-white' }}">
                <svg class="w-5 h-5 {{ $active === 'users' ? 'text-emerald-300' : 'text-emerald-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <span>Pengguna / User</span>
            </a>
        </nav>
    </div>

    <!-- Bagian Bawah: Marketplace & Pengguna Aktif -->
    <div class="space-y-4">
        <div class="pt-4 border-t border-emerald-800/60">
            <a href="{{ route('home') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl bg-emerald-800/40 border border-emerald-700/50 hover:bg-emerald-800/80 text-emerald-200 hover:text-white transition">
                <svg class="w-5 h-5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span class="text-sm font-medium">Lihat Marketplace</span>
            </a>
        </div>
        <div class="px-2">
            <div class="text-[11px] text-emerald-400 font-medium uppercase tracking-wider">PENGGUNA AKTIF</div>
            <div class="text-sm font-semibold text-white truncate">
                {{ auth()->user()->name ?? 'Admin ReUseMarket' }}
            </div>
        </div>
    </div>
</aside>