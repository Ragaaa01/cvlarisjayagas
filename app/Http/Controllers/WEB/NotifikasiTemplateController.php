<?php

namespace App\Http\Controllers\WEB;

use Illuminate\Http\Request;
use App\Models\NotifikasiTemplate;
use App\Http\Controllers\Controller;

class NotifikasiTemplateController extends Controller
{
    public function index()
    {
        $templates = NotifikasiTemplate::latest()->paginate(10);
        return view('admin.pages.notifikasi_template.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.pages.notifikasi_template.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_template' => 'required|string|max:255',
            'hari_set' => 'required|integer|min:0',
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        NotifikasiTemplate::create($request->only(['nama_template', 'hari_set', 'judul', 'isi']));

        return redirect()->route('admin.notifikasi_template.index')->with('success', 'Template Notifikasi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $template = NotifikasiTemplate::findOrFail($id);
        return view('admin.pages.notifikasi_template.edit', compact('template'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_template' => 'required|string|max:255',
            'hari_set' => 'required|integer|min:0',
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        $template = NotifikasiTemplate::findOrFail($id);
        $template->update($request->only(['nama_template', 'hari_set', 'judul', 'isi']));

        return redirect()->route('admin.notifikasi_template.index')->with('success', 'Template Notifikasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $template = NotifikasiTemplate::findOrFail($id);
        $template->delete();
        return redirect()->route('admin.notifikasi_template.index')->with('success', 'Template Notifikasi berhasil dihapus.');
    }
}
