<?php

// app/Http/Controllers/TabungController.php
namespace App\Http\Controllers;
use App\Models\Tabung;
use Illuminate\Http\Request;

class TabungController extends Controller {
    public function index() {
        $tabungs = Tabung::with(['jenisTabung', 'statusTabung'])->get();
        return response()->json($tabungs);
    }

    public function show($kodeTabung) {
        $tabung = Tabung::with(['jenisTabung', 'statusTabung'])
            ->where('kode_tabung', $kodeTabung)
            ->firstOrFail();
        return response()->json($tabung);
    }
}
