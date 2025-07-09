<?php

namespace App\Http\Controllers\WEB;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use App\Models\DetailTransaksi;
use App\Http\Controllers\Controller;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan daftar peminjaman
     */
    public function index()
    {
        $peminjamans = Peminjaman::with(['detailTransaksi.transaksi.perorangan', 'detailTransaksi.transaksi.perusahaan'])
            ->where('status_pinjam', 'aktif')
            ->oldest()
            ->paginate(10);
        return view('admin.pages.peminjaman.index', compact('peminjamans'));
    }

    /**
     * Menampilkan detail peminjaman
     */
    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load([
            'detailTransaksi.transaksi.akun',
            'detailTransaksi.transaksi.perorangan',
            'detailTransaksi.transaksi.perusahaan',
            'detailTransaksi.tabung.jenisTabung',
            'detailTransaksi.jenisTransaksi'
        ]);
        return view('admin.pages.peminjaman.show', compact('peminjaman'));
    }
}
