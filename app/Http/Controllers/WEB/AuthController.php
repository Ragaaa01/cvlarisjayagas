<?php

namespace App\Http\Controllers\WEB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('register');
    }
    public function showLoginForm()
    {
        return view('login');
    }
     public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Check if akun status aktif
            if (!$user->status_aktif) {
                Auth::logout();
                return back()->with('error', 'Akun Anda belum aktif.');
            }

            return redirect()->intended($user->role === 'administrator' ? route('admin.dashboard') : route('user.home'));
        }

        return back()->with('error', 'Email atau password salah.');
    }

    public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login')->with('success', 'Anda berhasil logout.');
}

    
}
