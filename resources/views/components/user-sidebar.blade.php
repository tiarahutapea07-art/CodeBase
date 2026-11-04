
@props(['active' => ''])

<aside class="w-64 bg-emerald-900 text-white flex flex-col justify-between p-5 shadow-lg flex-shrink-0">
    <div>
        <!-- Logo -->
        <div class="mb-8 px-2">
            <a href="{{ route('home') }}" class="block group">
                <span class="block text-2xl font-black text-white tracking-wider leading-none">ReUse</span>
                <span class="block text-xl font-extrabold text-emerald-400 tracking-widest uppercase leading-tight group-hover:text-emerald-300 transition">Market</span>
            </a>
        </div>

        <!-- Menu User -->
        <nav class="space-y-1.5">

            <a href="{{ route('profile.index') }}"
               class="flex items-center space-x-3 px-4 py-3 rounded-xl transition {{ $active === 'profile' ? 'bg-emerald-700/60 text-emerald-100 font-medium' : 'hover:bg-emerald-800/50 text-emerald-200/80 hover:text-white' }}">
                <span>👤</span>
                <span>Profil Saya</span>
            </a>

            <a href="{{ route('profile.products') }}"
               class="flex items-center space-x-3 px-4 py-3 rounded-xl transition {{ $active === 'products' ? 'bg-emerald-700/60 text-emerald-100 font-medium' : 'hover:bg-emerald-800/50 text-emerald-200/80 hover:text-white' }}">
                <span>📦</span>
                <span>Produk Saya</span>
            </a>

            <a href="{{ route('profile.orders') }}"
               class="flex items-center space-x-3 px-4 py-3 rounded-xl transition {{ $active === 'orders' ? 'bg-emerald-700/60 text-emerald-100 font-medium' : 'hover:bg-emerald-800/50 text-emerald-200/80 hover:text-white' }}">
                <span>🛍️</span>
                <span>Pesanan Saya</span>
            </a>

            <a href="{{ route('nego.index') }}"
               class="flex items-center space-x-3 px-4 py-3 rounded-xl transition {{ $active === 'negotiations' ? 'bg-emerald-700/60 text-emerald-100 font-medium' : 'hover:bg-emerald-800/50 text-emerald-200/80 hover:text-white' }}">
                <span>🤝</span>
                <span>Negosiasi Saya</span>
            </a>

            <a href="{{ route('inbox') }}"
               class="flex items-center space-x-3 px-4 py-3 rounded-xl transition {{ $active === 'chat' ? 'bg-emerald-700/60 text-emerald-100 font-medium' : 'hover:bg-emerald-800/50 text-emerald-200/80 hover:text-white' }}">
                <span>💬</span>
                <span>Chat Saya</span>
            </a>
        </nav>
    </div>

    <!-- Bagian Bawah -->
    <div class="space-y-4">
        <div class="pt-4 border-t border-emerald-800/60">
            <a href="{{ route('home') }}"
               class="flex items-center space-x-3 px-4 py-2.5 rounded-xl bg-emerald-800/40 border border-emerald-700/50 hover:bg-emerald-800/80 text-emerald-200 hover:text-white transition">
                <span>🏠</span>
                <span class="text-sm font-medium">Lihat Marketplace</span>
            </a>
        </div>

        <div class="px-2">
            <div class="text-[11px] text-emerald-400 font-medium uppercase tracking-wider">PENGGUNA AKTIF</div>
            <div class="text-sm font-semibold text-white truncate">
                {{ auth()->user()->name }}
            </div>
        </div>

        <form action="{{ route('logout') }}" method="POST" class="px-2">
            @csrf
            <button type="submit" class="w-full text-left text-sm text-red-300 hover:text-white transition">
                Keluar
            </button>
        </form>
    </div>
</aside>
