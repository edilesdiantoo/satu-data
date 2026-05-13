<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthentikasiController extends Controller
{
    public function login()
    {
        if (! auth::user()) {
            return view('authentikasi.auth-login');
        } else {
            return redirect()->back();
        }
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            if (Auth::user()->role == 'admin') {
                return redirect()->route('dashboard')->with('success', 'Selamat Anda Berhasil Login !');
            } elseif (Auth::user()->role == 'opd') {
                return redirect()->route('opd_dashboard')->with('success', 'Selamat Anda Berhasil Login !');
            }
        }

        return redirect()->route('login')->with('toast_error', 'Email atau Password Salah !');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
