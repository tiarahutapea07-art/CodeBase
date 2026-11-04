<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Saya - ReUseMarket</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-emerald-50/30 text-gray-800">
    <x-user-sidebar active="profile" />
    <main class="flex-1 p-8 overflow-y-auto">
        <a href="{{ route('profile.index') }}"> 
            Profil Saya 
        </a>
        <p class="text-gray-500 mb-8">
            Kelola informasi akun ReUseMarket kamu.
        </p>
        <div class="bg-white rounded-2xl shadow-sm border border-emerald-100 p-8 max-w-3xl">

                <div class="flex items-center gap-5 mb-8">
                    <div class="w-20 h-20 rounded-full bg-emerald-600 text-white flex items-center justify-center text-3xl font-bold">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>

                    <div>
                        <h2 class="text-xl font-bold">{{ $user->name }}</h2>
                        <p class="text-gray-500">{{ $user->email }}</p>
                    </div>
                </div>

                <hr class="mb-6">

                <h3 class="text-lg font-bold mb-5">Informasi Akun</h3>

                <div class="space-y-4">
                    <div>
                        <label class="text-sm text-gray-500">Nama Lengkap</label>
                        <p class="font-semibold">{{ $user->name }}</p>
                    </div>

                    <div>
                        <label class="text-sm text-gray-500">Email</label>
                        <p class="font-semibold">{{ $user->email }}</p>
                    </div>

                    <div>
                        <label class="text-sm text-gray-500">Tanggal Bergabung</label>
                        <p class="font-semibold">
                            {{ $user->created_at->format('d M Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </main>
</body>
</html>