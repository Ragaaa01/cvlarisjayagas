<?php

namespace App\Http\Controllers\WEB;

use App\Models\Perorangan;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PeroranganController extends Controller
{
    public function index()
{
    $perorangans = Perorangan::with('perusahaan')->get();

    // Ambil ID perusahaan yang sudah dipakai
    $usedPerusahaanIds = Perorangan::whereNotNull('id_perusahaan')->pluck('id_perusahaan');

    // Filter hanya perusahaan yang belum dipakai
    $perusahaans = Perusahaan::whereNotIn('id_perusahaan', $usedPerusahaanIds)->get();

    return view('admin.pages.perorangan.data_perorangan', compact('perorangans', 'perusahaans'));
}

public function create()
{
    $usedPerusahaanIds = Perorangan::whereNotNull('id_perusahaan')->pluck('id_perusahaan');
    $perusahaans = Perusahaan::whereNotIn('id_perusahaan', $usedPerusahaanIds)->get();

    return view('admin.pages.perorangan.create', compact('perusahaans'));
}

    public function store(Request $request)
{
    $request->validate([
        'nama_lengkap' => 'required',
        'nik' => 'required',
        'no_telepon' => 'required',
        'alamat' => 'required',
        'id_perusahaan' => 'nullable|exists:perusahaans,id_perusahaan',
    ]);

    // Cek duplikat berdasarkan NIK atau No Telepon
    $duplicate = Perorangan::where('nik', $request->nik)
                    ->orWhere('no_telepon', $request->no_telepon)
                    ->first();

    if ($duplicate) {
        return redirect()->back()->withInput()->with('warning', 'Data dengan NIK atau No Telepon yang sama sudah ada.');
    }

    Perorangan::create($request->all());

    return redirect()->route('data_perorangan')->with('success', 'Data berhasil ditambahkan.');
}

public function edit($id)
{
    $perorangan = Perorangan::findOrFail($id);

    $usedPerusahaanIds = Perorangan::whereNotNull('id_perusahaan')
        ->where('id_perorangan', '!=', $id)
        ->pluck('id_perusahaan');

    $perusahaans = Perusahaan::whereNotIn('id_perusahaan', $usedPerusahaanIds)->get();

    return view('admin.pages.perorangan.edit', compact('perorangan', 'perusahaans'));
}


public function update(Request $request, $id)
{
    $request->validate([
        'nama_lengkap' => 'required',
        'nik' => 'required',
        'no_telepon' => 'required',
        'alamat' => 'required',
        'id_perusahaan' => 'nullable|exists:perusahaans,id_perusahaan',
    ]);

    // Cek duplikat (selain data dirinya sendiri)
    $duplicate = Perorangan::where(function ($query) use ($request) {
            $query->where('nik', $request->nik)
                  ->orWhere('no_telepon', $request->no_telepon);
        })
        ->where('id_perorangan', '!=', $id)
        ->first();

    if ($duplicate) {
        return redirect()->back()->withInput()->with('warning', 'Data dengan NIK atau No Telepon yang sama sudah ada.');
    }

    $perorangan = Perorangan::findOrFail($id);

    $isChanged =
        $perorangan->nama_lengkap !== $request->nama_lengkap ||
        $perorangan->nik !== $request->nik ||
        $perorangan->no_telepon !== $request->no_telepon ||
        $perorangan->alamat !== $request->alamat ||
        $perorangan->id_perusahaan != $request->id_perusahaan;

    if (!$isChanged) {
        return redirect()->route('data_perorangan')->with('info', 'Tidak ada perubahan pada data.');
    }

    $perorangan->update($request->all());

    return redirect()->route('data_perorangan')->with('success', 'Data berhasil diperbarui.');
}



    public function destroy($id)
    {
        $perorangan = Perorangan::findOrFail($id);
        $perorangan->delete();

        return redirect()->route('data_perorangan')->with('success', 'Data berhasil dihapus.');
    }

    public function show($id)
    {
        $perorangan = Perorangan::with('perusahaan')->findOrFail($id);
        return view('admin.pages.perorangan.show', compact('perorangan'));
    }

}
