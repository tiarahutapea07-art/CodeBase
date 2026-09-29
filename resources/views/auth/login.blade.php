<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $admin ? 'Login Admin' : 'Masuk' }} - ReUseMarket</title>
    @include('auth._style')
</head>
<body>
<div class="card">
    <a href="/" class="logo"><span class="g">Re</span>UseMarket</a>

    @if($admin)
        <p class="eyebrow">ADMIN AREA</p>
        <h1>Login Admin</h1>
        <p class="sub">Khusus pengelola ReUseMarket.</p>
    @else
        <p class="eyebrow">SELAMAT DATANG</p>
        <h1>Masuk</h1>
        <p class="sub">Masuk untuk jual, beli, dan donasi barang bekas.</p>
    @endif

    <form method="POST" action="{{ $admin ? route('admin.login') : route('login') }}">
        @csrf

        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
        @error('email') <div class="error">{{ $message }}</div> @enderror

        <label for="password">Password</label>
        <input id="password" type="password" name="password" required>

        @unless($admin)
            <label class="check"><input type="checkbox" name="remember"> Ingat saya</label>
        @endunless

        <button type="submit" class="btn">Masuk</button>
    </form>

    @unless($admin)
        <p class="foot">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
    @endunless
</div>
</body>
</html>