
@props(['active' => ''])

<aside class="w-64 h-screen sticky top-0 bg-emerald-900 text-white flex flex-col justify-between p-5 shadow-lg flex-shrink-0 self-start">
    <div>

        <!-- LOGO -->
        <div class="mb-8 px-2">
            <a href="{{ route('home') }}" class="block group">
                <span class="block text-2xl font-black text-white tracking-wider leading-none">
                    ReUse
                </span>
                <span class="block text-xl font-extrabold text-emerald-400 tracking-widest uppercase leading-tight group-hover:text-emerald-300 transition">
                    Market
                </span>
            </a>
        </div>

        <!-- MENU PENGGUNA -->
        <nav class="space-y-1.5">

            <!-- DASHBOARD -->
            <a href="{{ route('user.dashboard') }}"
               class="flex items-center gap-4 px-4 py-3 rounded-xl transition
               {{ $active === 'dashboard' ? 'bg-emerald-700/60 text-emerald-100 font-medium' : 'hover:bg-emerald-800/50 text-emerald-200/80 hover:text-white' }}">

                <svg xmlns="http://www.w3.org/2000/svg"
                     width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7" rx="1"/>
                    <rect x="14" y="3" width="7" height="7" rx="1"/>
                    <rect x="3" y="14" width="7" height="7" rx="1"/>
                    <rect x="14" y="14" width="7" height="7" rx="1"/>
                </svg>

                <span>Dashboard</span>
            </a>


            <!-- BARANG SAYA -->
            <a href="{{ route('my-products.index') }}"
                class="flex items-center gap-4 px-4 py-3 rounded-xl transition
                {{ $active === 'my-products' ? 'bg-emerald-700/60 text-emerald-100 font-medium' : 'hover:bg-emerald-800/50 text-emerald-200/80 hover:text-white' }}">

                <svg xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 2-1.73z"/>
                    <path d="m3.3 7 8.7 5 8.7-5"/>
                    <path d="M12 22V12"/>
                </svg>

                <span>Barang Saya</span>
            </a>


            <!-- FAVORIT SAYA -->
            <a href="{{ url('/favorit') }}"
               class="flex items-center gap-4 px-4 py-3 rounded-xl transition
               {{ $active === 'favorites' ? 'bg-emerald-700/60 text-emerald-100 font-medium' : 'hover:bg-emerald-800/50 text-emerald-200/80 hover:text-white' }}">

                <svg xmlns="http://www.w3.org/2000/svg"
                     width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.8-7.5 1.1-1.1a5.5 5.5 0 0 0-.1-7.8z"/>
                </svg>

                <span>Favorit Saya</span>
            </a>


            <!-- PROFIL SAYA -->
            <a href="{{ route('profile.index') }}"
               class="flex items-center gap-4 px-4 py-3 rounded-xl transition
               {{ $active === 'profile' ? 'bg-emerald-700/60 text-emerald-100 font-medium' : 'hover:bg-emerald-800/50 text-emerald-200/80 hover:text-white' }}">

                <svg xmlns="http://www.w3.org/2000/svg"
                     width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>

                <span>Profil Saya</span>
            </a>

        </nav>
    </div>


    <!-- BAGIAN BAWAH -->
    <div class="space-y-4">

        <!-- MARKETPLACE -->
        <div class="pt-4 border-t border-emerald-800/60">

            <a href="{{ route('home') }}"
               class="flex items-center gap-4 px-4 py-2.5 rounded-xl bg-emerald-800/40 border border-emerald-700/50 hover:bg-emerald-800/80 text-emerald-200 hover:text-white transition">

                <svg xmlns="http://www.w3.org/2000/svg"
                     width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m3 10 9-7 9 7"/>
                    <path d="M5 9v12h14V9"/>
                    <path d="M9 21v-7h6v7"/>
                </svg>

                <span class="text-sm font-medium">Lihat Marketplace</span>
            </a>

        </div>


        <!-- PENGGUNA AKTIF -->
        <div class="px-2">

            <div class="text-[11px] text-emerald-400 font-medium uppercase tracking-wider">
                PENGGUNA AKTIF
            </div>

            <div class="text-sm font-semibold text-white truncate">
                {{ auth()->user()->name }}
            </div>

        </div>

    </div>

</aside>
