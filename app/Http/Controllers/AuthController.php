<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'role' => 'required|in:merchant,admin',
        ]);

        // Merchant perlu persetujuan admin, admin langsung aktif
        $status = $request->role === 'merchant' ? 'pending' : 'approved';

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'status'   => $status,
        ]);

        if ($request->role === 'merchant') {
            return redirect('/login')->with('success', 'Pendaftaran berhasil! Akun kamu sedang menunggu persetujuan Admin. Kamu akan dihubungi setelah disetujui.');
        }

        return redirect('/login')->with('success', 'Registrasi berhasil, silakan login.');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Cek apakah Role yang dipilih sesuai dengan di Database
            if ($user->role !== $request->role) {
                Auth::logout();
                return back()->with('error', 'Hak akses tidak sesuai! Pastikan pilih Role yang benar.');
            }

            // Cek status akun merchant
            if ($user->role === 'merchant') {
                if ($user->status === 'pending') {
                    Auth::logout();
                    return back()->with('error', '⏳ Akun kamu masih menunggu persetujuan Admin. Harap bersabar.');
                }

                if ($user->status === 'rejected') {
                    Auth::logout();
                    return back()->with('error', '❌ Maaf, pendaftaran akun kamu telah ditolak oleh Admin. Hubungi admin untuk informasi lebih lanjut.');
                }

                if ($user->status === 'suspended') {
                    Auth::logout();
                    return back()->with('error', '⛔ Akun kamu telah dinonaktifkan oleh Admin. Hubungi admin untuk informasi lebih lanjut.');
                }
            }

            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
