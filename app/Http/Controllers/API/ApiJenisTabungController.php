<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\JenisTabung;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ApiJenisTabungController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(): JsonResponse
    {
        try {
            $jenisTabung = JenisTabung::all();
            return response()->json([
                'success' => true,
                'message' => 'Data jenis tabung berhasil diambil',
                'data' => $jenisTabung,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Gagal mengambil jenis tabung', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data jenis tabung: ' . $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    /**
     * Get available jenis tabung for selection.
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAvailableJenisTabung()
    {
        $jenis_tabungs = JenisTabung::withCount(['tabungs' => function ($query) {
            $query->where('id_status_tabung', 1); // Hanya hitung tabung yang tersedia
        }])
        ->having('tabungs_count', '>', 0)
        ->get();

        return response()->json([
            'success' => true,
            'data' => $jenis_tabungs->map(function ($jenis) {
                return [
                    'id_jenis_tabung' => $jenis->id_jenis_tabung,
                    'nama_jenis' => $jenis->nama_jenis,
                    'harga' => $jenis->harga,
                    'jumlah_tersedia' => $jenis->tabungs_count,
                ];
            })
        ], 200);
    }
}