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

    public function create()
    {
        return view('admin.pages.perusahaan.create');
    }

    public function store(Request $req)
    {
        $req->validate([
            'nama_perusahaan' => 'required|string',
            'alamat_perusahaan' => 'required|string',
            'email_perusahaan' => 'required|email'
        ]);

        // Cek duplikasi berdasarkan nama dan email
        $exists = Perusahaan::where('nama_perusahaan', $req->nama_perusahaan)
            ->orWhere('email_perusahaan', $req->email_perusahaan)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Nama atau Email perusahaan sudah terdaftar.');
        }

        Perusahaan::create($req->only(['nama_perusahaan','alamat_perusahaan','email_perusahaan']));
        return redirect()->route('data_perusahaan')->with('success','Data berhasil disimpan.');
    }

    public function show($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        return view('admin.pages.perusahaan.show', compact('perusahaan'));
    }

    public function edit($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        return view('admin.pages.perusahaan.edit', compact('perusahaan'));
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'nama_perusahaan' => 'required|string',
            'alamat_perusahaan' => 'required|string',
            'email_perusahaan' => 'required|email'
        ]);

        $perusahaan = Perusahaan::findOrFail($id);

        // Cek duplikasi nama/email kecuali untuk dirinya sendiri
        $exists = Perusahaan::where(function ($query) use ($req) {
                $query->where('nama_perusahaan', $req->nama_perusahaan)
                      ->orWhere('email_perusahaan', $req->email_perusahaan);
            })
            ->where('id_perusahaan', '!=', $id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Nama atau Email sudah digunakan oleh perusahaan lain.');
        }

        $perusahaan->update($req->only(['nama_perusahaan','alamat_perusahaan','email_perusahaan']));
        return redirect()->route('data_perusahaan')->with('success','Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $row = Perusahaan::findOrFail($id);
        $row->delete();
        return redirect()->route('data_perusahaan')->with('success','Data berhasil dihapus.');
    }
}
