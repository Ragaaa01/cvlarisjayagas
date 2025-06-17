<?php

namespace App\Http\Controllers\WEB;

use App\Models\Tabung;
use App\Models\JenisTabung;
use App\Models\StatusTabung;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TabungController extends Controller
{
     public function index()
{
    $tabungs = Tabung::with(['jenisTabung', 'statusTabung'])->get();
    $jenisTabungs = JenisTabung::all();
    $statusTabungs = StatusTabung::all();
    return view('admin.pages.tabung.data_tabung', compact('tabungs', 'jenisTabungs', 'statusTabungs'));
}

    public function create()
    {
        $jenisTabungs = JenisTabung::all();
        $statusTabungs = StatusTabung::all();
        return view('admin.pages.tabung.modal_create', compact('jenisTabungs', 'statusTabungs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_tabung' => 'required',
            'id_jenis_tabung' => 'required',
            'id_status_tabung' => 'required',
        ]);

        Tabung::create($request->all());
        return redirect()->route('data_tabung')->with('success', 'Tabung created successfully.');
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
        return view('admin.pages.tabung.modal_edit', compact('tabung', 'jenisTabungs', 'statusTabungs'));
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
        return redirect()->route('data_tabung')->with('success', 'Tabung updated successfully.');
    }

    public function destroy($id)
    {
        $tabung = Tabung::findOrFail($id);
        $tabung->delete();
        return redirect()->route('data_tabung')->with('success', 'Tabung deleted successfully.');
    }
}
