<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Akun;
use App\Models\Perorangan;
use App\Models\Tabung;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiAdministratorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');

        $this->middleware(function ($request, $next) {
            if (Auth::user()->role !== 'administrator') {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                ], 403);
            }
            return $next($request);
        });
    }

    public function profile()
    {
        $user = Auth::guard('api')->user();

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diambil',
            'data' => [
                'id_akun' => $user->id_akun,
                'email' => $user->email,
                'role' => $user->role,
                'status_aktif' => $user->status_aktif,
                'nama_lengkap' => $user->perorangan?->nama_lengkap ?? 'N/A',
                'no_telepon' => $user->perorangan?->no_telepon ?? 'N/A',
            ],
        ], 200);

        return response()->json([
            'success' => false,
            'message' => 'Invalid email or password',
        ], 401);
    }

    public function statistics()
    {
        $totalTransaksiBerjalan = Transaksi::whereHas('statusTransaksi', function ($query) {
            $query->where('status', 'pending');
        })->count();

        $totalTransaksi = Transaksi::whereHas('statusTransaksi', function ($query) {
            $query->whereIn('status', ['pending', 'success']);
        })->count();

        $stokTabung = Tabung::whereHas('statusTabung', function ($query) {
            $query->where('status_tabung', 'tersedia');
        })->count();

        $riwayatTransaksi = Transaksi::whereHas('statusTransaksi', function ($query) {
            $query->where('status', 'success');
        })->count();

        $jumlahPelanggan = Perorangan::count();

        return response()->json([
            'success' => true,
            'data' => [
                'total_transaksi_berjalan' => $totalTransaksiBerjalan,
                'total_transaksi' => $totalTransaksi,
                'stok_tabung' => $stokTabung,
                'riwayat_transaksi' => $riwayatTransaksi,
                'jumlah_pelanggan' => $jumlahPelanggan,
            ],
        ], 200);
    }

    public function pendingAccounts()
    {
        $pendingAccounts = Akun::where('role', 'pelanggan')
            ->where('status_aktif', false)
            ->get(['id_akun', 'email']);

        return response()->json([
            'success' => true,
            'data' => $pendingAccounts,
        ], 200);
    }

    public function confirmAccount(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:akuns,email',
    ]);

    $akun = Akun::where('email', $request->email)
        ->where('role', 'pelanggan')
        ->first();

    if (!$akun) {
        return response()->json([
            'success' => false,
            'message' => 'Akun tidak ditemukan',
        ], 404);
    }

    if ($akun->status_aktif) {
        return response()->json([
            'success' => false,
            'message' => 'Akun sudah aktif',
        ], 400);
    }

    $akun->status_aktif = true;
    $akun->save();

    return response()->json([
        'success' => true,
        'message' => 'Akun berhasil dikonfirmasi',
    ], 200);
}
}
