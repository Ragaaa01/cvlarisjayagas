<?php

namespace App\Http\Controllers\WEB;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use App\Models\DetailTransaksi;
use App\Http\Controllers\Controller;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with('detailTransaksi.transaksi')->latest()->paginate(10);
        return view('admin.pages.peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $detailTransaksis = DetailTransaksi::all();
        return view('admin.pages.peminjaman.create', compact('detailTransaksis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_detail_transaksi' => 'required|exists:detail_transaksis,id_detail_transaksi',
            'tanggal_pinjam' => 'required|date',
            'status_pinjam' => 'required|in:aktif,selesai',
        ]);

        Peminjaman::create($request->only('id_detail_transaksi', 'tanggal_pinjam', 'status_pinjam'));

        return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $detailTransaksis = DetailTransaksi::all();
        return view('admin.pages.peminjaman.edit', compact('peminjaman', 'detailTransaksis'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_detail_transaksi' => 'required|exists:detail_transaksis,id_detail_transaksi',
            'tanggal_pinjam' => 'required|date',
            'status_pinjam' => 'required|in:aktif,selesai',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update($request->only('id_detail_transaksi', 'tanggal_pinjam', 'status_pinjam'));

        return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->delete();
        return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman berhasil dihapus.');
    }
}
