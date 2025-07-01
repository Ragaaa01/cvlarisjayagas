<?php

namespace App\Http\Controllers\WEB;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalians = Pengembalian::with('peminjaman')->latest()->paginate(10);
        return view('admin.pages.pengembalian.index', compact('pengembalians'));
    }

    public function create()
    {
        $peminjamans = Peminjaman::where('status_pinjam', 'aktif')->get();
        return view('admin.pages.pengembalian.create', compact('peminjamans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_peminjaman' => 'required|exists:peminjamans,id_peminjaman',
            'tanggal_kembali' => 'required|date',
            'kondisi_tabung' => 'required|in:baik,rusak',
            'keterangan' => 'required|string',
        ]);

        Pengembalian::create($request->only('id_peminjaman', 'tanggal_kembali', 'kondisi_tabung', 'keterangan'));

        $peminjaman = Peminjaman::find($request->id_peminjaman);
        $peminjaman->update(['status_pinjam' => 'selesai']);

        return redirect()->route('admin.pengembalian.index')->with('success', 'Pengembalian berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);
        $peminjamans = Peminjaman::where('status_pinjam', 'aktif')->get();
        return view('admin.pages.pengembalian.edit', compact('pengembalian', 'peminjamans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_peminjaman' => 'required|exists:peminjamans,id_peminjaman',
            'tanggal_kembali' => 'required|date',
            'kondisi_tabung' => 'required|in:baik,rusak',
            'keterangan' => 'required|string',
        ]);

        $pengembalian = Pengembalian::findOrFail($id);
        $pengembalian->update($request->only('id_peminjaman', 'tanggal_kembali', 'kondisi_tabung', 'keterangan'));

        return redirect()->route('admin.pengembalian.index')->with('success', 'Pengembalian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);
        $pengembalian->delete();
        return redirect()->route('admin.pengembalian.index')->with('success', 'Pengembalian berhasil dihapus.');
    }
}
