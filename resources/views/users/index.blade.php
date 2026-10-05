<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengguna / User - ReUseMarket</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-emerald-50/30 text-gray-800">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar Navigation (Disamakan Persis) -->
        <x-sidebar active="users" />

        <!-- Main Content Area -->
        <main class="flex-1 p-8 overflow-y-auto">
            <header class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Daftar Pengguna / User</h2>
                    <p class="text-sm text-gray-500">Kelola akun pengguna dan hak akses terdaftar.</p>
                </div>
                <button type="button" onclick="openModal('userModal')" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl font-medium shadow-sm transition">
                    + Tambah Pengguna
                </button>
            </header>

            @if(session('success'))
                <div class="p-4 mb-6 text-sm text-emerald-800 bg-emerald-100 rounded-xl border border-emerald-200">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="p-4 mb-6 text-sm text-red-800 bg-red-100 rounded-xl border border-red-200">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-emerald-100 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-emerald-50/50 text-xs uppercase font-semibold text-emerald-900">
                        <tr>
                            <th class="p-4">#</th>
                            <th class="p-4">Nama Lengkap</th>
                            <th class="p-4">Email</th>
                            <th class="p-4">Tanggal Bergabung</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($users as $user)
                            <tr class="hover:bg-emerald-50/20 transition">
                                <td class="p-4 text-gray-400">{{ $loop->iteration }}</td>
                                <td class="p-4 font-semibold text-gray-800">{{ $user->name }}</td>
                                <td class="p-4 text-gray-600">{{ $user->email }}</td>
                                <td class="p-4 text-gray-500">{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</td>
                                <td class="p-4 text-center space-x-2">
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus akun ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 font-medium">Hapus</button>
                                        </form>
                                    @else
                                        <span class="text-xs text-emerald-600 font-semibold">(Akun Saya)</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-6 text-center text-gray-400">Belum ada pengguna terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Modal Pengguna -->
    <div id="userModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden transform transition-all">
            
            <!-- Header Hijau Emerald -->
            <div class="bg-emerald-900 px-6 py-4 flex items-center justify-between text-white">
                <h3 class="text-lg font-bold">Tambah Pengguna Baru</h3>
                <button type="button" onclick="closeModal('userModal')" class="text-emerald-200 hover:text-white text-xl font-bold transition">
                    &times;
                </button>
            </div>

            <!-- Form Body -->
            <form action="{{ route('users.store') }}" method="POST" class="p-6 space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Nama Lengkap</label>
                    <input type="text" name="name" placeholder="Masukkan nama pengguna" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-slate-700 text-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Email</label>
                    <input type="email" name="email" placeholder="contoh@email.com" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-slate-700 text-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Role / Peran</label>
                    <select name="role" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-slate-700 text-sm">
                        <option value="admin">Admin</option>
                        <option value="petugas">Petugas</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Kata Sandi (Password)</label>
                    <input type="password" name="password" placeholder="••••••••" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-slate-700 text-sm">
                </div>

                <div class="flex items-center justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeModal('userModal')" class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-600 font-semibold text-sm hover:bg-slate-200 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 text-white font-semibold text-sm hover:bg-emerald-700 shadow-md shadow-emerald-600/30 transition">
                        Simpan Data
                    </button>
                </div>
            </form>

        </div>
    </div>

    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }
    </script>
</body>
</html>