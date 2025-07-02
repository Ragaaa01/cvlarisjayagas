<?php

namespace App\Http\Controllers\WEB;

use Illuminate\Http\Request;
use App\Models\RiwayatTransaksi;
use App\Http\Controllers\Controller;

class RiwayatTransaksiController extends Controller
{
    public function index()
    {
        $riwayatTransaksis = RiwayatTransaksi::with(['transaksi', 'akun', 'perorangan'])->latest()->id()->paginate(10);
        return view('admin.pages.riwayatTransaksi.index', compact('riwayatTransaksis'));
    }

    public function show($id)
    {
        $riwayatTransaksi = RiwayatTransaksi::with(['transaksi', 'akun', 'asi', 'perorangan'])->transaksi()->findOrFail($id);
        return view('admin.pages.riwayatTransaksi.show', compact('riwayatTransaksi'));
    }
}
