<?php

namespace App\Http\Controllers\WEB;

use Illuminate\Http\Request;
use App\Models\StatusTransaksi;
use App\Http\Controllers\Controller;

class StatusTransaksiController extends Controller
{
     public function index()
{
    // Ubah dari ->latest() menjadi ->orderBy('id_status_transaksi', 'asc')
    $statusTransaksis = StatusTransaksi::orderBy('id_status_transaksi', 'asc')->paginate(10);
    return view('admin.pages.status_transaksi.index', compact('statusTransaksis'));
}

    public function create()
    {
        return view('admin.pages.status_transaksi.create');
    }

    public function show($id)
{
    $statusTransaksi = StatusTransaksi::findOrFail($id);
    return view('admin.pages.status_transaksi.show', compact('statusTransaksi'));
}

    public function store(Request $request)
{
    $request->validate([
        'status' => 'required|in:success,pending,failed',
    ]);

    // Cek apakah status sudah ada
    $exists = StatusTransaksi::where('status', $request->status)->exists();
    if ($exists) {
        return redirect()->route('admin.status_transaksi.index')
                         ->withErrors(['status' => 'Status sudah ada. Duplikasi tidak diperbolehkan.'])
                         ->withInput();
    }

    StatusTransaksi::create($request->only('status'));

    return redirect()->route('admin.status_transaksi.index')
                     ->with('success', 'Status Transaksi berhasil ditambahkan.');
}


    public function edit($id)
    {
        $statusTransaksi = StatusTransaksi::findOrFail($id);
        return view('admin.pages.status_transaksi.edit', compact('statusTransaksi'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:success,pending,failed',
    ]);

    $statusTransaksi = StatusTransaksi::findOrFail($id);

    // Cek duplikasi jika status diubah
    if ($statusTransaksi->status !== $request->status) {
        $exists = StatusTransaksi::where('status', $request->status)->exists();
        if ($exists) {
            return redirect()->route('admin.status_transaksi.index')
                             ->withErrors(['status' => 'Status sudah ada. Duplikasi tidak diperbolehkan.'])
                             ->withInput();
        }
    }

    $statusTransaksi->update($request->only('status'));

    return redirect()->route('admin.status_transaksi.index')
                     ->with('success', 'Status Transaksi berhasil diperbarui.');
}


    public function destroy($id)
    {
        $statusTransaksi = StatusTransaksi::findOrFail($id);
        $statusTransaksi->delete();
        return redirect()->route('admin.status_transaksi.index')->with('success', 'Status Transaksi berhasil dihapus.');
    }
}
