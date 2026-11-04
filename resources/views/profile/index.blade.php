<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - ReUseMarket</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-emerald-50/30 text-gray-800">

<div class="min-h-screen flex">

    <!-- SIDEBAR -->
    <x-user-sidebar active="profile" />

    <!-- KONTEN -->
    <main class="flex-1 p-5 md:p-8 overflow-y-auto">

        <div class="max-w-3xl mx-auto">

            <!-- HEADER -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-800">
                    Profil Saya
                </h1>

                <p class="text-gray-500 mt-1">
                    Kelola informasi akun ReUseMarket kamu.
                </p>
            </div>

            <!-- NOTIFIKASI BERHASIL -->
            @if(session('success'))
                <div class="mb-5 bg-emerald-100 border border-emerald-200 text-emerald-800 px-5 py-3 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            <!-- NOTIFIKASI ERROR -->
            @if($errors->any())
                <div class="mb-5 bg-red-100 border border-red-200 text-red-700 px-5 py-3 rounded-xl">
                    <p class="font-semibold mb-2">
                        Periksa kembali data yang kamu masukkan:
                    </p>

                    <ul class="list-disc pl-5 text-sm space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- KARTU PROFIL -->
            <div class="bg-white rounded-2xl shadow-sm border border-emerald-100 overflow-hidden mb-7">

                <!-- IDENTITAS -->
                <div class="bg-emerald-900 p-8 flex items-center gap-5">

                    <div class="w-20 h-20 rounded-full bg-emerald-600 flex items-center justify-center text-white text-3xl font-bold border-4 border-emerald-400 shadow-sm">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>

                    <div class="min-w-0">
                        <h2 class="text-xl font-bold text-white">
                            {{ $user->name }}
                        </h2>

                        <p class="text-emerald-200 text-sm mt-1 break-all">
                            {{ $user->email }}
                        </p>

                        <span class="inline-block mt-2 text-xs bg-emerald-700 text-emerald-100 px-3 py-1 rounded-full">
                            Pengguna ReUseMarket
                        </span>
                    </div>

                </div>

                <!-- FORM EDIT PROFIL -->
                <div class="p-6 md:p-8">

                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-gray-800">
                            Informasi Akun
                        </h3>

                        <p class="text-sm text-gray-500 mt-1">
                            Kamu dapat mengubah nama dan email akun di bawah ini.
                        </p>
                    </div>

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- NAMA -->
                        <div class="mb-5">
                            <label for="name" class="block text-sm font-semibold mb-2">
                                Nama Lengkap
                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                required
                                autocomplete="name"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 transition"
                            >
                        </div>

                        <!-- EMAIL -->
                        <div class="mb-6">
                            <label for="email" class="block text-sm font-semibold mb-2">
                                Alamat Email
                            </label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                required
                                autocomplete="email"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 transition"
                            >
                        </div>

                        <!-- TOMBOL -->
                        <div class="flex flex-col-reverse sm:flex-row justify-end gap-3">

                            <a href="{{ route('user.dashboard') }}"
                               class="text-center px-5 py-3 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 transition">
                                Kembali
                            </a>

                            <button
                                type="submit"
                                class="px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold transition shadow-sm">
                                Simpan Perubahan
                            </button>

                        </div>

                    </form>

                </div>

            </div>

            <!-- KARTU EDIT PASSWORD -->
            <div class="bg-white rounded-2xl shadow-sm border border-emerald-100 overflow-hidden">

                <!-- HEADER PASSWORD -->
                <div class="p-6 md:p-8 border-b border-gray-100">

                    <div class="flex items-center gap-3">

                        <div class="w-11 h-11 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-800">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 width="23"
                                 height="23"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2"
                                 stroke-linecap="round"
                                 stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-gray-800">
                                Edit Password
                            </h3>

                            <p class="text-sm text-gray-500 mt-1">
                                Perbarui password untuk menjaga keamanan akunmu.
                            </p>
                        </div>

                    </div>

                </div>

                <!-- FORM PASSWORD -->
                <div class="p-6 md:p-8">

                    <form action="{{ route('profile.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- PASSWORD SAAT INI -->
                        <div class="mb-5">

                            <label for="current_password"
                                   class="block text-sm font-semibold mb-2">
                                Password Saat Ini
                            </label>

                            <div class="relative">

                                <input
                                    type="password"
                                    id="current_password"
                                    name="current_password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="Masukkan password saat ini"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 pr-12 outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 transition">

                                <button
                                    type="button"
                                    onclick="togglePassword('current_password', this)"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-emerald-700">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         width="20" height="20"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>

                                </button>

                            </div>
                        </div>

                        <!-- PASSWORD BARU -->
                        <div class="mb-5">

                            <label for="new_password"
                                   class="block text-sm font-semibold mb-2">
                                Password Baru
                            </label>

                            <div class="relative">

                                <input
                                    type="password"
                                    id="new_password"
                                    name="new_password"
                                    required
                                    minlength="8"
                                    autocomplete="new-password"
                                    placeholder="Masukkan password baru (minimal 8 karakter)"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 pr-12 outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 transition">

                                <button
                                    type="button"
                                    onclick="togglePassword('new_password', this)"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-emerald-700">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         width="20" height="20"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>

                                </button>

                            </div>

                            <p class="text-xs text-gray-400 mt-2">
                                Gunakan minimal 8 karakter untuk password baru.
                            </p>

                        </div>

                        <!-- KONFIRMASI PASSWORD -->
                        <div class="mb-7">

                            <label for="new_password_confirmation"
                                   class="block text-sm font-semibold mb-2">
                                Konfirmasi Password Baru
                            </label>

                            <div class="relative">

                                <input
                                    type="password"
                                    id="new_password_confirmation"
                                    name="new_password_confirmation"
                                    required
                                    minlength="8"
                                    autocomplete="new-password"
                                    placeholder="Masukkan ulang password baru"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 pr-12 outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 transition">

                                <button
                                    type="button"
                                    onclick="togglePassword('new_password_confirmation', this)"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-emerald-700">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         width="20" height="20"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>

                                </button>

                            </div>

                        </div>

                        <!-- TOMBOL UPDATE PASSWORD -->
                        <div class="flex justify-end">

                            <button
                                type="submit"
                                class="w-full sm:w-auto px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold transition shadow-sm">

                                Update Password

                            </button>

                        </div>

                    </form>

                </div>

            </div>

            <!-- FOOTER -->
            <div class="text-center text-xs text-gray-400 mt-8 mb-4">
                © {{ date('Y') }} ReUseMarket. All rights reserved.
            </div>

        </div>

    </main>

</div>

<!-- SCRIPT TAMPILKAN PASSWORD -->
<script>
    function togglePassword(inputId, button) {
        const input = document.getElementById(inputId);

        if (input.type === 'password') {
            input.type = 'text';
        } else {
            input.type = 'password';
        }
    }
</script>

</body>
</html>