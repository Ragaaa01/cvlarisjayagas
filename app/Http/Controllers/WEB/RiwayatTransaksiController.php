<?php

namespace App\Http\Controllers\WEB;

use Illuminate\Http\Request;
use App\Models\RiwayatTransaksi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class RiwayatTransaksiController extends Controller
{
    public function index()
    {
        $riwayatTransaksis = RiwayatTransaksi::with([
            'transaksi.statusTransaksi',
            'akun.perorangan',
            'perorangan.perusahaan',
            'perusahaan'
        ])
            ->latest()
            ->paginate(10);

        return view('admin.pages.riwayat_transaksi.index', compact('riwayatTransaksis'));
    }

    public function show($id)
    {
        try {
            $riwayatTransaksi = RiwayatTransaksi::with([
                'transaksi.detailTransaksis.tabung.jenisTabung',
                'transaksi.detailTransaksis.jenisTransaksi',
                'transaksi.detailTransaksis.peminjaman.pengembalian',
                'transaksi.tagihan', // Pastikan relasi tagihan dimuat
                'akun.perorangan',
                'perorangan.perusahaan',
                'perusahaan'
            ])
                ->findOrFail($id);

            return view('admin.pages.riwayat_transaksi.show', compact('riwayatTransaksi'));
        } catch (\Exception $e) {
            Log::error('Gagal memuat riwayat transaksi: ' . $e->getMessage());
            return redirect()->route('admin.riwayat_transaksi.index')
                ->with('error', 'Gagal memuat detail riwayat transaksi: ' . $e->getMessage());
        }
    }
}