<?php

namespace App\Http\Controllers\WEB;

use App\Models\Tagihan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagihanController extends Controller
{
   public function index()
    {
        $tagihans = Tagihan::with('transaksi')->latest()->paginate(10);
        return view('admin.pages.tagihan.index', compact('tagihans'));
    }

    public function create()
    {
        $transaksis = Transaksi::all();
        return view('admin.pages.tagihan.create', compact('transaksis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_transaksi' => 'required|exists:transaksis,id_transaksi',
            'jumlah_dibayar' => 'required|numeric|min:0',
            'sisa' => 'required|numeric|min:0',
            'status' => 'required|in:lunas,belum_lunas',
            'tanggal_bayar_tagihan' => 'nullable|date',
            'hari_keterlambatan' => 'nullable|integer|min:0',
            'periode_ke' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $tagihan = Tagihan::create($request->all());
        $tagihan->calculateDenda();

        return redirect()->route('admin.tagihan.index')->with('success', 'Tagihan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $transaksis = Transaksi::all();
        return view('admin.pages.tagihan.edit', compact('tagihan', 'transaksis'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_transaksi' => 'required|exists:transaksis,id_transaksi',
            'jumlah_dibayar' => 'required|numeric|min:0',
            'sisa' => 'required|numeric|min:0',
            'status' => 'required|in:lunas,belum_lunas',
            'tanggal_bayar_tagihan' => 'nullable|date',
            'hari_keterlambatan' => 'nullable|integer|min:0',
            'periode_ke' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $tagihan = Tagihan::findOrFail($id);
        $tagihan->update($request->all());
        $tagihan->calculateDenda();

        return redirect()->route('admin.tagihan.index')->with('success', 'Tagihan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $tagihan->delete();
        return redirect()->route('admin.tagihan.index')->with('success', 'Tagihan berhasil dihapus.');
    }
}
