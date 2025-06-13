<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Tabung;
use App\Models\JenisTabung;
use App\Models\StatusTabung;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApiTabungController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $tabungs = Tabung::with(['jenisTabung', 'statusTabung'])->get();
            return response()->json([
                'success' => true,
                'message' => 'Data tabung berhasil diambil',
                'data' => $tabungs,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data tabung: ' . $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $tabung = Tabung::with(['jenisTabung', 'statusTabung'])->find($id);
            if (!$tabung) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tabung tidak ditemukan',
                    'data' => null,
                ], 404);
            }
            return response()->json([
                'success' => true,
                'message' => 'Data tabung berhasil diambil',
                'data' => $tabung,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data tabung: ' . $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    public function showByKode(Request $request)
    {
        try {
            $kodeTabung = $request->query('kode_tabung');
            if (!$kodeTabung) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kode tabung diperlukan',
                    'data' => null,
                ], 400);
            }

            $tabung = Tabung::with(['jenisTabung', 'statusTabung'])
                ->where('kode_tabung', $kodeTabung)
                ->first();

            if (!$tabung) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tabung tidak ditemukan',
                    'data' => null,
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data tabung berhasil diambil',
                'data' => $tabung,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data tabung: ' . $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_tabung' => 'required|string|max:20|unique:tabungs,kode_tabung',
            'id_jenis_tabung' => 'required|integer|exists:jenis_tabungs,id_jenis_tabung',
            'id_status_tabung' => 'required|integer|exists:status_tabungs,id_status_tabung',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Kode tabung sudah ada atau data tidak valid',
                'data' => $validator->errors(),
            ], 422);
        }

        try {
            $tabung = Tabung::create([
                'id_tabung' => $request->id_tabung,
                'kode_tabung' => $request->kode_tabung,
                'id_jenis_tabung' => $request->id_jenis_tabung,
                'id_status_tabung' => $request->id_status_tabung,
            ]);

            $tabung->load(['jenisTabung', 'statusTabung']);

            return response()->json([
                'success' => true,
                'message' => 'Tabung berhasil ditambahkan',
                'data' => $tabung,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan tabung: ' . $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $tabung = Tabung::find($id);
        if (!$tabung) {
            return response()->json([
                'success' => false,
                'message' => 'Tabung tidak ditemukan',
                'data' => null,
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'kode_tabung' => 'required|string|max:20|unique:tabungs,kode_tabung,' . $id . ',id_tabung',
            'id_jenis_tabung' => 'required|integer|exists:jenis_tabungs,id_jenis_tabung',
            'id_status_tabung' => 'required|integer|exists:status_tabungs,id_status_tabung',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'data' => $validator->errors(),
            ], 422);
        }

        try {
            $tabung->update([
                'kode_tabung' => $request->kode_tabung,
                'id_jenis_tabung' => $request->id_jenis_tabung,
                'id_status_tabung' => $request->id_status_tabung,
            ]);

            $tabung->load(['jenisTabung', 'statusTabung']);

            return response()->json([
                'success' => true,
                'message' => 'Tabung berhasil diperbarui',
                'data' => $tabung,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui tabung: ' . $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tabung = Tabung::find($id);
        if (!$tabung) {
            return response()->json([
                'success' => false,
                'message' => 'Tabung tidak ditemukan',
                'data' => null,
            ], 404);
        }

        try {
            $tabung->delete();
            return response()->json([
                'success' => true,
                'message' => 'Tabung berhasil dihapus',
                'data' => null,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus tabung: ' . $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    /**
     * Get available tabungs.
     * @return JsonResponse
     */
    public function getTabungsTersedia()
    {
        try {
            $tabungs = Tabung::where('id_status_tabung', 1) // Tersedia
                ->with('jenisTabung')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $tabungs->map(function ($tabung) {
                    return [
                        'id_tabung' => $tabung->id_tabung,
                        'kode_tabung' => $tabung->kode_tabung,
                        'nama_jenis' => $tabung->jenisTabung->nama_jenis,
                        'harga' => $tabung->jenisTabung->harga,
                    ];
                }),
            ], 200);
        } catch (Exception $e) {
            \Log::error('Gagal mengambil tabung tersedia', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil tabung tersedia: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get active cylinders for the authenticated customer.
     * @return JsonResponse
     */
    public function getTabungAktif(): JsonResponse
    {
        try {
            $user = Auth::user();
            $activeCylinders = Peminjaman::whereHas('detailTransaksi.transaksi', function ($query) use ($user) {
                $query->where('id_akun', $user->id_akun);
            })
                ->where('status_pinjam', 'aktif')
                ->join('detail_transaksis', 'peminjamans.id_detail_transaksi', '=', 'detail_transaksis.id_detail_transaksi')
                ->join('tabungs', 'detail_transaksis.id_tabung', '=', 'tabungs.id_tabung')
                ->join('jenis_tabungs', 'tabungs.id_jenis_tabung', '=', 'jenis_tabungs.id_jenis_tabung')
                ->select([
                    'tabungs.id_tabung',
                    'tabungs.kode_tabung',
                    'tabungs.id_jenis_tabung',
                    'tabungs.id_status_tabung',
                    'jenis_tabungs.nama_jenis as nama_jenis',
                ])
                ->get();

            return response()->json([
                'success' => true,
                'data' => $activeCylinders->map(function ($item) {
                    return [
                        'id_tabung' => $item->id_tabung,
                        'kode_tabung' => $item->kode_tabung,
                        'id_jenis_tabung' => $item->id_jenis_tabung,
                        'id_status_tabung' => $item->id_status_tabung,
                        'nama_jenis' => $item->nama_jenis,
                    ];
                })->toArray(),
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Gagal mengambil tabung aktif', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil tabung aktif: ' . $e->getMessage(),
            ], 500);
        }
    }
}