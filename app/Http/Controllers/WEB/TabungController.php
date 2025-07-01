<?php

namespace App\Http\Controllers\WEB;

use App\Models\Tabung;
use App\Models\JenisTabung;
use App\Models\StatusTabung;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TabungController extends Controller
{
     public function index(Request $request)
    {
        $jenisTabungs = JenisTabung::all();
        $query = Tabung::with(['jenisTabung', 'statusTabung']);

        if ($request->filled('jenis')) {
            $query->where('id_jenis_tabung', $request->jenis);
        }

        $tabungs = $query->get();

        return view('admin.pages.tabung.data_tabung', compact('tabungs', 'jenisTabungs'));
    }

    public function create()
    {
        $jenisTabungs = JenisTabung::all();
        $statusTabungs = StatusTabung::all();
        return view('admin.pages.tabung.create', compact('jenisTabungs', 'statusTabungs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_tabung' => 'required|unique:tabungs,kode_tabung',
            'id_jenis_tabung' => 'required',
            'id_status_tabung' => 'required',
        ]);

        Tabung::create([
            'kode_tabung' => $request->kode_tabung,
            'id_jenis_tabung' => $request->id_jenis_tabung,
            'id_status_tabung' => $request->id_status_tabung,
        ]);

        return redirect()->route('data_tabung')->with('success', 'Tabung berhasil ditambahkan.');
    }

    public function show($id)
    {
        $tabung = Tabung::with(['jenisTabung', 'statusTabung'])->findOrFail($id);
        return view('admin.pages.tabung.show', compact('tabung'));
    }

    public function edit($id)
    {
        $tabung = Tabung::findOrFail($id);
        $jenisTabungs = JenisTabung::all();
        $statusTabungs = StatusTabung::all();
        return view('admin.pages.tabung.edit', compact('tabung', 'jenisTabungs', 'statusTabungs'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_tabung' => 'required',
            'id_jenis_tabung' => 'required',
            'id_status_tabung' => 'required',
        ]);

        $tabung = Tabung::findOrFail($id);
        $tabung->update($request->all());

        return redirect()->route('data_tabung')->with('success', 'Tabung berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tabung = Tabung::findOrFail($id);
        $tabung->delete();
        return redirect()->route('data_tabung')->with('success', 'Tabung berhasil dihapus.');
    }
}
