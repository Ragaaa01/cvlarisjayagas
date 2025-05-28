<?php

namespace App\Http\Controllers\API;

use App\Models\Akun;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class ApiAuthController extends Controller
{
public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:akuns,email',
            'password' => 'required|min:6|confirmed', // Gunakan field "password_confirmation"
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
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
            'message' => 'Registrasi berhasil! Akun Anda akan segera diaktifkan oleh admin.',
            'data' => [
                'akun_id' => $akun->id_akuns,
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
                'akun_id' => $akun->id_akuns,
                'email' => $akun->email,
                'role' => $akun->role,
            ]
        ], 200);
    }

    public function logout(Request $request) {
        
        // return "oke";
        $request->user()->tokens()->delete();
        
        return response()->json(['message' => 'Logged out Berhasil']);
    }
}
