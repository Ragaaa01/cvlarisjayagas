<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class ApiAuthController extends Controller
{
public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:akuns,email',
            'password' => 'required|min:8|confirmed', // Gunakan field "password_confirmation"
        ], [
            'email.unique' => 'Email sudah terdaftar. Silakan gunakan email lain atau login.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $akun = Akun::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pelanggan',
            'status_aktif' => false, // Tidak langsung aktif
        ]);

        return response()->json([   
            'success' => true,
            'message' => 'Pendaftaran berhasil! Akun Anda akan aktif setelah dikonfirmasi oleh Administrator.',
            'data' => [
                'id_akun' => $akun->id_akun,
                'email' => $akun->email,
                'role' => $akun->role,
                'status_aktif' => $akun->status_aktif,
            ]
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah!',
            ], 401);
        }

        $akun = Auth::user();

        if (!$akun->status_aktif) {
            Auth::logout();
            return response()->json([
                'success' => false,
                'message' => 'Akun Anda belum aktif. Silakan hubungi admin.',
            ], 403);
        }

        $token = $akun->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login sukses',
            'token' => $token,
            'data' => [  
                'id_akun' => $akun->id_akun,
                'email' => $akun->email,
                'role' => $akun->role,
            ]
        ], 200);
    }

    public function logout(Request $request) 
    {
    try {
        $user = Auth::user();
        if ($user) {
            $user->tokens()->delete();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil logout',
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'User tidak terautentikasi',
        ], 401);
    } catch (\Exception $e) {
        Log::error('Logout error', ['error' => $e->getMessage()]);
        return response()->json([
            'success' => false,
            'message' => 'Gagal logout: ' . $e->getMessage(),
        ], 500);
    }
}

}
