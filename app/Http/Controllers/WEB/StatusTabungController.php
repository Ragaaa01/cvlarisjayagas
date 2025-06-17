<?php

namespace App\Http\Controllers\WEB;

use App\Models\StatusTabung;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatusTabungController extends Controller
{
    public function index()
    {
        $data = StatusTabung::all();
        return view('admin.pages.status_tabung.data_status_tabung', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'status_tabung' => 'required|in:tersedia,dipinjam,rusak,hilang',
        ]);

        StatusTabung::create($request->all());
        return redirect()->back()->with('success', 'Status tabung berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status_tabung' => 'required|in:tersedia,dipinjam,rusak,hilang',
        ]);

        $status = StatusTabung::findOrFail($id);
        $status->update($request->all());

        return redirect()->back()->with('success', 'Status tabung berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $status = StatusTabung::findOrFail($id);
        $status->delete();

        return redirect()->back()->with('success', 'Status tabung berhasil dihapus.');
    }

    public function show($id)
    {
        $status = StatusTabung::findOrFail($id);
        return view('admin.pages.status_tabung.show', compact('status'));
    }
}
