<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    //Login
    public function showLogin()
    {
        return view('auth.login', ['admin' => false]);
    }

    public function login(Request $request)
{
    $credentials = $request->validate([
        'email'    => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();

        // Admin masuk ke dashboard admin
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        // Pengguna biasa masuk ke homepage marketplace
        return redirect()->route('home');
    }

    return back()
        ->withErrors([
            'email' => 'Email atau password salah.'
        ])
        ->onlyInput('email');
}

    // ---------- LOGIN ADMIN ----------
    public function showAdminLogin()
    {
        return view('auth.login', ['admin' => true]);
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            if (!auth()->user()->isAdmin()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors(['email' => 'Akun ini bukan admin.'])->onlyInput('email');
            }

            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    // ---------- REGISTER PENGGUNA ----------
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
{
    $data = $request->validate([
        'name'     => ['required', 'string', 'max:255'],
        'email'    => ['required', 'email', 'unique:users,email'],
        'password' => ['required', 'min:8', 'confirmed'],
    ]);

    $user = User::create([
        'name'     => $data['name'],
        'email'    => $data['email'],
        'password' => $data['password'],
        'role'     => 'user',
    ]);

    Auth::login($user);

    $request->session()->regenerate();

    return redirect()->route('home');
}

    // ---------- LOGOUT ----------
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

    