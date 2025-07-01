<?php

namespace App\Http\Controllers\WEB;

use App\Models\Akun;
use App\Models\Perorangan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AkunController extends Controller
{
     public function data_akun()
    {
        $akuns = Akun::with('perorangan')->get();

        // Ambil semua ID perorangan yang sudah dipakai
        $usedPeroranganIds = Akun::whereNotNull('id_perorangan')->pluck('id_perorangan')->toArray();

        // Ambil perorangan yang belum digunakan (untuk tambah akun)
        $perorangans = Perorangan::whereNotIn('id_perorangan', $usedPeroranganIds)->get();

        return view('admin.pages.akun.data_akun', compact('akuns', 'perorangans'));
    }

    public function create()
{
    $usedPeroranganIds = Akun::whereNotNull('id_perorangan')->pluck('id_perorangan')->toArray();
    $perorangans = Perorangan::whereNotIn('id_perorangan', $usedPeroranganIds)->get();

    return view('admin.pages.akun.create', compact('perorangans'));
}

    public function show($id)
    {
        $akun = Akun::with('perorangan')->findOrFail($id);
        return view('admin.pages.akun.show_data_akun', compact('akun'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:akuns,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:administrator,pelanggan',
            'id_perorangan' => 'nullable|numeric'
        ]);

        Akun::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'status_aktif' => $request->has('status_aktif'),
             'id_perorangan' => $validated['id_perorangan'] ?? null,
        ]);

        return redirect()->route('data_akun')->with('success', 'Akun berhasil ditambahkan.');
    }

    public function edit($id)
{
    $akun = Akun::with('perorangan')->findOrFail($id);
    $usedIds = Akun::where('id_akun', '!=', $id)->pluck('id_perorangan')->toArray();
    $perorangans = Perorangan::whereNotIn('id_perorangan', $usedIds)
                    ->orWhere('id_perorangan', $akun->id_perorangan)->get();

    return view('admin.pages.akun.edit', compact('akun', 'perorangans'));
}

    public function update(Request $request, $id)
{
    $akun = Akun::findOrFail($id);

    $validated = $request->validate([
        'email' => 'required|email|unique:akuns,email,' . $id . ',id_akun',
        'role' => 'required|in:administrator,pelanggan',
        'id_perorangan' => 'nullable|numeric|unique:akuns,id_perorangan,' . $id . ',id_akun',
    ]);

    $status_aktif = $request->has('status_aktif') ? 1 : 0;

    // Cek apakah ada perubahan data
    $isChanged = 
        $akun->email !== $validated['email'] ||
        $akun->role !== $validated['role'] ||
        $akun->status_aktif != $status_aktif ||
        $akun->id_perorangan != ($validated['id_perorangan'] ?? null);

    if (!$isChanged) {
        return redirect()->route('data_akun')->with('info', 'Tidak ada perubahan pada data akun.');
    }

    // Jika ada perubahan, update
    $akun->update([
        'email' => $validated['email'],
        'role' => $validated['role'],
        'status_aktif' => $status_aktif,
        'id_perorangan' => $validated['id_perorangan'] ?? null,
    ]);

    return redirect()->route('data_akun')->with('success', 'Akun berhasil diperbarui.');
}


    public function destroy($id)
    {
        Akun::destroy($id);
        return redirect()->route('data_akun')->with('success', 'Akun berhasil dihapus');
    }

    public function searchPerorangan(Request $request)
{
    $term = $request->get('q');
    $currentAkunId = $request->get('current_id'); // optional

    // Ambil ID yang sudah digunakan oleh akun lain
    $usedPeroranganIds = Akun::when($currentAkunId, function ($query) use ($currentAkunId) {
        return $query->where('id_akun', '!=', $currentAkunId);
    })
    ->whereNotNull('id_perorangan')
    ->pluck('id_perorangan')
    ->toArray();

    $results = Perorangan::whereNotIn('id_perorangan', $usedPeroranganIds)
        ->where(function ($query) use ($term) {
            $query->where('id_perorangan', 'LIKE', "%$term%")
                  ->orWhere('nama_lengkap', 'LIKE', "%$term%")
                  ->orWhere('nik', 'LIKE', "%$term%");
        })
        ->limit(20)
        ->get();

    return response()->json(
        $results->map(function ($item) {
            return [
                'id' => $item->id_perorangan,
                'text' => "{$item->id_perorangan} - {$item->nama_lengkap} - {$item->nik}",
            ];
        })
    );
}


}
