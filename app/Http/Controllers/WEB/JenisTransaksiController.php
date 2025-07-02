<?php

namespace App\Http\Controllers\WEB;

use Illuminate\Http\Request;
use App\Models\JenisTransaksi;
use App\Http\Controllers\Controller;

class JenisTransaksiController extends Controller
{
     public function index()
    {
        $jenisTransaksis = JenisTransaksi::orderBy('id_jenis_transaksi', 'asc')->paginate(10);
        return view('admin.pages.jenis_transaksi.index', compact('jenisTransaksis'));
    }

    public function create()
    {
        return view('admin.pages.jenis_transaksi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis_transaksi' => 'required|string|max:255|unique:jenis_transaksis,nama_jenis_transaksi',
        ]);

        JenisTransaksi::create([
            'nama_jenis_transaksi' => $request->nama_jenis_transaksi,
        ]);

        return redirect()->route('jenis_transaksi.index')->with('success', 'Jenis Transaksi berhasil ditambahkan.');
    }

    public function show($id)
    {
        $jenisTransaksi = JenisTransaksi::findOrFail($id);
        return view('admin.pages.jenis_transaksi.show', compact('jenisTransaksi'));
    }

    public function edit($id)
    {
        $jenisTransaksi = JenisTransaksi::findOrFail($id);
        return view('admin.pages.jenis_transaksi.edit', compact('jenisTransaksi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_jenis_transaksi' => 'required|string|max:255|unique:jenis_transaksis,nama_jenis_transaksi,' . $id . ',id_jenis_transaksi',
        ]);

        $jenisTransaksi = JenisTransaksi::findOrFail($id);
        $jenisTransaksi->update($request->only('nama_jenis_transaksi'));

        return redirect()->route('jenis_transaksi.index')->with('success', 'Jenis Transaksi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jenisTransaksi = JenisTransaksi::findOrFail($id);
        $jenisTransaksi->delete();

        return redirect()->route('jenis_transaksi.index')->with('success', 'Jenis Transaksi berhasil dihapus.');
    }
}
