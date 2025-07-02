<?php

namespace App\Http\Controllers\WEB;

use App\Models\Tagihan;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use App\Models\NotifikasiTemplate;
use App\Http\Controllers\Controller;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifikasis = Notifikasi::with(['tagihan', 'template'])->latest()->paginate(10);
        return view('admin.pages.notifikasi.index', compact('notifikasis'));
    }

    public function create()
    {
        $tagihans = Tagihan::all();
        $templates = NotifikasiTemplate::all();
        return view('admin.pages.notifikasi.create', compact('tagihans', 'templates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_tagihan' => 'required|exists:tagihans,id_tagihan',
            'id_template' => 'required|exists:notifikasi_templates,id_template',
            'tanggal_terjadwal' => 'required|date',
            'status_baca' => 'required|boolean',
            'waktu_dikirim' => 'required|date_format:Y-m-d H:i:s',
        ]);

        Notifikasi::create($request->only('id_tagihan', 'id_template', 'tanggal_terjadwal', 'status_baca', 'waktu_dikirim'));

        return redirect()->route('admin.notifikasi.index')->with('success', 'Notifikasi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $notifikasi = Notifikasi::findOrFail($id);
        $tagihans = Tagihan::all();
        $templates = NotifikasiTemplate::all();
        return view('admin.pages.notifikasi.edit', compact('notifikasi', 'tagihans', 'templates'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_tagihan' => 'required|exists:tagihans,id_tagihan',
            'id_template' => 'required|exists:notifikasi_templates,id_template',
            'tanggal_terjadwal' => 'required|date',
            'status_baca' => 'required|boolean',
            'waktu_dikirim' => 'required|date_format:Y-m-d H:i:s',
        ]);

        $notifikasi = Notifikasi::findOrFail($id);
        $notifikasi->update($request->only('id_tagihan', 'id_template', 'tanggal_terjadwal', 'status_baca', 'waktu_dikirim'));

        return redirect()->route('admin.notifikasi.index')->with('success', 'Notifikasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $notifikasi = Notifikasi::findOrFail($id);
        $notifikasi->delete();
        return redirect()->route('admin.notifikasi.index')->with('success', 'Notifikasi berhasil dihapus.');
    }

    public function markAsRead($id)
    {
        $notifikasi = Notifikasi::findOrFail($id);
        $notifikasi->update(['status_baca' => true]);
        return redirect()->route('admin.notifikasi.index')->with('success', 'Notifikasi ditandai sebagai dibaca.');
    }
}
