
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - ReUseMarket</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background-color: #fdf9ef;
            font-family: Arial, sans-serif;
        }

        .auth-card {
            width: 100%;
            max-width: 420px;
            background: white;
            border-radius: 24px;
            padding: 40px 36px;
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.07);
        }

        .auth-input {
            width: 100%;
            height: 44px;
            padding: 0 18px;
            border: 1px solid #e5e7eb;
            border-radius: 30px;
            background: #f9fafb;
            outline: none;
        }

        .auth-input:focus {
            border-color: #059669;
            box-shadow: 0 0 0 2px rgba(5, 150, 105, 0.1);
        }

        .auth-button {
            width: 100%;
            height: 46px;
            border-radius: 30px;
            background: #059669;
            color: white;
            font-weight: bold;
            transition: 0.2s;
        }

        .auth-button:hover {
            background: #047857;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-5">

    <div class="auth-card">

        <!-- LOGO -->
        <h1 class="text-2xl font-extrabold text-slate-900 mb-6">
            <span class="text-emerald-600">Re</span>UseMarket
        </h1>

        <!-- JUDUL -->
        <p class="text-orange-700 font-bold text-xs tracking-[4px] mb-2">
            BERGABUNG BERSAMA KAMI
        </p>

        <h2 class="text-3xl font-extrabold text-slate-900 mb-2">
            Daftar
        </h2>

        <p class="text-gray-500 text-sm mb-6">
            Buat akun untuk jual, beli, dan donasi barang bekas.
        </p>

        <!-- PESAN ERROR -->
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4 text-sm">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- FORM REGISTER -->
        <form action="{{ route('register') }}" method="POST">
            @csrf

            <!-- NAMA -->
            <div class="mb-4">
                <label class="block text-sm font-semibold text-slate-900 mb-2">
                    Nama Lengkap
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="auth-input"
                    required
                >
            </div>

            <!-- EMAIL -->
            <div class="mb-4">
                <label class="block text-sm font-semibold text-slate-900 mb-2">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="auth-input"
                    required
                >
            </div>

            <!-- PASSWORD -->
            <div class="mb-4">
                <label class="block text-sm font-semibold text-slate-900 mb-2">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    placeholder="Minimal 8 karakter"
                    class="auth-input"
                    required
                >
            </div>

            <!-- KONFIRMASI PASSWORD -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-slate-900 mb-2">
                    Konfirmasi Password
                </label>

                <input
                    type="password"
                    name="password_confirmation"
                    class="auth-input"
                    required
                >
            </div>

            <!-- TOMBOL DAFTAR -->
            <button type="submit" class="auth-button">
                Daftar
            </button>

        </form>

        <!-- LINK LOGIN -->
        <p class="text-center text-sm text-gray-500 mt-6">
            Sudah punya akun?

            <a href="{{ route('login') }}"
               class="text-emerald-600 font-bold hover:underline">
                Masuk
            </a>
        </p>

    </div>

</body>
</html>
