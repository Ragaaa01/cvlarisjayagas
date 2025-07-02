<?php

namespace App\Http\Controllers\WEB;

use App\Models\JenisTabung;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JenisTabungController extends Controller
{
      public function index()
    {
        $jenis_tabung = JenisTabung::all();
        return view('admin.pages.jenis_tabung.data_jenis_tabung', compact('jenis_tabung'));
    }

    public function create()
    {
        return view('admin.pages.jenis_tabung.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_jenis' => 'required|unique:jenis_tabungs,kode_jenis',
            'nama_jenis' => 'required|unique:jenis_tabungs,nama_jenis',
            'harga' => 'required|numeric'
        ]);

        JenisTabung::create($request->only('kode_jenis', 'nama_jenis', 'harga'));
        return redirect()->route('data_jenis_tabung')->with('success', 'Jenis tabung berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jenis = JenisTabung::findOrFail($id);
        return view('admin.pages.jenis_tabung.edit', compact('jenis'));
    }

    public function update(Request $request, $id)
    {
        $jenis = JenisTabung::findOrFail($id);

        $request->validate([
            'kode_jenis' => 'required|unique:jenis_tabungs,kode_jenis,' . $id . ',id_jenis_tabung',
            'nama_jenis' => 'required',
            'harga' => 'required|numeric'
        ]);

        $jenis->update($request->only('kode_jenis', 'nama_jenis', 'harga'));
        return redirect()->route('data_jenis_tabung')->with('success', 'Jenis tabung berhasil diperbarui');
    }

    public function destroy($id)
    {
        JenisTabung::findOrFail($id)->delete();
        return redirect()->route('data_jenis_tabung')->with('success', 'Jenis tabung berhasil dihapus');
    }

    public function show($id)
    {
        $jenis = JenisTabung::findOrFail($id);
        return view('admin.pages.jenis_tabung.show', compact('jenis'));
    }
}
