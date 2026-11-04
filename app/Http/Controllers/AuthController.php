<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class AuthController extends Controller
{
    // Memeriksa password lama maupun password dua tahap
    private function verifyAndUpgradePassword(User $user, string $plainPassword): bool
    {
        // Jika akun sudah menggunakan hashing dua tahap
        if ($user->password_hash_stage1) {
            return Hash::check($plainPassword, $user->password_hash_stage1)
                && Hash::check($user->password_hash_stage1, $user->password);
        }

        // Jika akun masih menggunakan hashing satu tahap
        if (!Hash::check($plainPassword, $user->password)) {
            return false;
        }

        // Perbarui akun lama menjadi hashing dua tahap
        $firstHash = Hash::make($plainPassword);
        $secondHash = Hash::make($firstHash);

        $user->password_hash_stage1 = $firstHash;
        $user->password = $secondHash;
        $user->save();

        return true;
    }

    // LOGIN PENGGUNA
    public function showLogin()
    {
        return view('auth.login', ['admin' => false]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (
            $user &&
            $this->verifyAndUpgradePassword($user, $credentials['password'])
        ) {
            Auth::login($user, $request->boolean('remember'));

            $request->session()->regenerate();

            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('home');
        }

        return back()
            ->withErrors([
                'email' => 'Email atau password salah.'
            ])
            ->onlyInput('email');
    }

    // LOGIN ADMIN
    public function showAdminLogin()
    {
        return view('auth.login', ['admin' => true]);
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (
            !$user ||
            !$user->isAdmin() ||
            !$this->verifyAndUpgradePassword($user, $credentials['password'])
        ) {
            return back()
                ->withErrors([
                    'email' => 'Email atau password salah, atau akun bukan admin.'
                ])
                ->onlyInput('email');
        }

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    // REGISTER PENGGUNA
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        // Hash tahap pertama
        $firstHash = Hash::make($data['password']);

        // Hash tahap kedua menggunakan hasil tahap pertama
        $secondHash = Hash::make($firstHash);

        $user = new User();

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password_hash_stage1 = $firstHash;
        $user->password = $secondHash;
        $user->role = 'user';

        $user->save();

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('home');
    }

    // LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
