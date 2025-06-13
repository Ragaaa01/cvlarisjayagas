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
            'id_perorangan' => $validated['id_perorangan']
        ]);

        return redirect()->route('data_akun')->with('success', 'Akun berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $akun = Akun::findOrFail($id);

        $validated = $request->validate([
            'email' => 'required|email|unique:akuns,email,' . $id . ',id_akun',
            'role' => 'required|in:administrator,pelanggan',
            'id_perorangan' => 'nullable|numeric'
        ]);

        $akun->update([
            'email' => $validated['email'],
            'role' => $validated['role'],
            'status_aktif' => $request->has('status_aktif'),
            'id_perorangan' => $validated['id_perorangan']
        ]);

        return redirect()->route('data_akun')->with('success', 'Akun berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Akun::destroy($id);
        return redirect()->route('data_akun')->with('success', 'Akun berhasil dihapus');
    }
}
