<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiPeminjamanResource;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class ApiPeminjamanController extends Controller
{
    public function indexAktif(Request $request)
    {
        // 1. Ambil kata kunci pencarian dari query parameter URL
        $searchQuery = $request->query('search');

        // 2. Mulai query dasar
        $peminjamanQuery = Peminjaman::where('status_pinjam', 'aktif');

        // 3. Terapkan kondisi pencarian HANYA JIKA ada input search
        $peminjamanQuery->when($searchQuery, function ($query, $search) {
            return $query->where(function ($q) use ($search) {
                // Cari berdasarkan kode tabung
                $q->whereHas('detailTransaksi.tabung', function ($subq) use ($search) {
                    $subq->where('kode_tabung', 'like', "%{$search}%");
                })
                    // ATAU cari berdasarkan nama pelanggan (walk-in)
                    ->orWhereHas('detailTransaksi.transaksi.perorangan', function ($subq) use ($search) {
                        $subq->where('nama_lengkap', 'like', "%{$search}%");
                    })
                    // ATAU cari berdasarkan nama pelanggan (via akun)
                    ->orWhereHas('detailTransaksi.transaksi.akun.perorangan', function ($subq) use ($search) {
                        $subq->where('nama_lengkap', 'like', "%{$search}%");
                    });
            });
        });

        // 4. Eager load relasi dan eksekusi query
        $peminjamanAktif = $peminjamanQuery->with([
            'detailTransaksi.tabung.jenisTabung',
            'detailTransaksi.transaksi.akun.perorangan.perusahaan',
            'detailTransaksi.transaksi.perorangan.perusahaan'
        ])
            ->latest('tanggal_pinjam')
            ->get();

        return ApiPeminjamanResource::collection($peminjamanAktif);
    }
}
