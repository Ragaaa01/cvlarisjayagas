<?php

namespace App\Http\Controllers\WEB;

use App\Models\Perusahaan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PerusahaanController extends Controller
{
    public function index()
    {
        $perusahaans = Perusahaan::all();
         return view('admin.pages.perusahaan.data_perusahaan', compact('perusahaans'));
    }

    public function store(Request $req)
    {
        $req->validate([
            'nama_perusahaan' => 'required|string',
            'alamat_perusahaan' => 'required|string',
            'email_perusahaan' => 'required|email'
        ]);
        Perusahaan::create($req->only(['nama_perusahaan','alamat_perusahaan','email_perusahaan']));
        return redirect()->back()->with('success','Data berhasil disimpan.');
    }

    public function show($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        return view('admin.pages.perusahaan.show', compact('perusahaan'));
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'nama_perusahaan' => 'required|string',
            'alamat_perusahaan' => 'required|string',
            'email_perusahaan' => 'required|email'
        ]);
        $row = Perusahaan::findOrFail($id);
        $row->update($req->only(['nama_perusahaan','alamat_perusahaan','email_perusahaan']));
        return redirect()->back()->with('success','Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $row = Perusahaan::findOrFail($id);
        $row->delete();
        return redirect()->back()->with('success','Data berhasil dihapus.');
    }
}
