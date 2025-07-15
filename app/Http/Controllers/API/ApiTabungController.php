<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiTabungResource;
use App\Models\Peminjaman;
use App\Models\Tabung;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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

    // /**
    //  * Menampilkan data tabung spesifik berdasarkan kode_tabung.
    //  *
    //  * @param Request $request
    //  * @return JsonResponse
    //  */
    // public function showByKode(Request $request): JsonResponse
    // {
    //     try {
    //         // 1. Validasi bahwa parameter 'kode_tabung' ada.
    //         $validated = $request->validate([
    //             'kode_tabung' => 'required|string',
    //         ]);

    //         // Ambil kode yang sudah divalidasi dan dibersihkan dari spasi.
    //         $kodeTabung = trim($validated['kode_tabung']);

    //         Log::info('Mencari tabung dengan kode: \'' . $kodeTabung . '\'');

    //         // 2. Gunakan query 'where' standar. Ini lebih bersih dan efisien.
    //         //    Secara default, ini case-insensitive di sebagian besar setup MySQL.
    //         $tabung = Tabung::with(['jenisTabung', 'statusTabung'])
    //             ->where('kode_tabung', $kodeTabung)
    //             ->first();

    //         // 3. Periksa apakah tabung ditemukan.
    //         if (!$tabung) {
    //             Log::warning('Tabung tidak ditemukan untuk kode: ' . $kodeTabung);
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Kode tabung tidak ditemukan',
    //                 'data' => null,
    //             ], 404);
    //         }

    //         Log::info('Tabung ditemukan: ' . json_encode($tabung));
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Data tabung berhasil diambil',
    //             'data' => new ApiTabungResource($tabung),
    //         ], 200);
    //     } catch (\Illuminate\Validation\ValidationException $e) {
    //         // Tangani error validasi
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Validasi gagal: ' . $e->getMessage(),
    //             'data' => null
    //         ], 422);
    //     } catch (\Exception $e) {
    //         // Tangani error lainnya
    //         Log::error('Error saat mengambil data tabung berdasarkan kode: ' . $e->getMessage());
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Gagal mengambil data tabung: Terjadi kesalahan pada server.',
    //             'data' => null,
    //         ], 500);
    //     }
    // }

    /**
     * Menampilkan data tabung spesifik berdasarkan kode_tabung dari parameter URL.
     *
     * @param string $kode_tabung
     * @return JsonResponse
     */
    public function showByKode(string $kode_tabung): JsonResponse
    {
        try {
            // Kode tabung sekarang diterima langsung sebagai argumen fungsi.
            // trim() untuk membersihkan spasi yang tidak sengaja terkirim.
            $kodeTabungClean = trim($kode_tabung);

            Log::info('Mencari tabung dengan kode: \'' . $kodeTabungClean . '\'');

            // Gunakan query 'where' untuk mencari tabung.
            $tabung = Tabung::with(['jenisTabung', 'statusTabung'])
                ->where('kode_tabung', $kodeTabungClean)
                ->first();

            // Periksa apakah tabung ditemukan.
            if (!$tabung) {
                Log::warning('Tabung tidak ditemukan untuk kode: ' . $kodeTabungClean);
                return response()->json([
                    'success' => false,
                    'message' => 'Kode tabung tidak ditemukan',
                ], 404);
            }

            // Tambahan: Validasi status tabung untuk alokasi
            if ($tabung->statusTabung->status_tabung !== 'tersedia') {
                return response()->json([
                    'success' => false,
                    'message' => 'Tabung dengan kode ' . $kodeTabungClean . ' tidak tersedia (status: ' . $tabung->statusTabung->status_tabung . ').',
                ], 422); // 422 Unprocessable Entity
            }

            Log::info('Tabung ditemukan dan tersedia: ' . json_encode($tabung));
            return response()->json([
                'success' => true,
                'message' => 'Data tabung berhasil diambil dan tersedia.',
                'data' => new ApiTabungResource($tabung),
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error saat mengambil data tabung berdasarkan kode: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data tabung: Terjadi kesalahan pada server.',
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_tabung' => [
                'required',
                'string',
                'max:20',
                Rule::unique('tabungs', 'kode_tabung')->whereNull('deleted_at'),
            ],
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
            'kode_tabung' => [
                'required',
                'string',
                'max:20',
                Rule::unique('tabungs', 'kode_tabung')->ignore($id, 'id_tabung')->whereNull('deleted_at'),
            ],
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
        $tabung = Tabung::findOrFail($id);
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
                        'jenis_tabung' => [
                            'id_jenis_tabung' => $tabung->jenisTabung->id_jenis_tabung,
                            'kode_jenis' => $tabung->jenisTabung->kode_jenis,
                            'nama_jenis' => $tabung->jenisTabung->nama_jenis,
                            'harga' => $tabung->jenisTabung->harga,
                        ],
                        'status_tabung' => [
                            'id_status_tabung' => $tabung->statusTabung->id_status_tabung,
                            'status_tabung' => $tabung->statusTabung->status_tabung,
                        ],
                    ];
                }),
            ], 200);
        } catch (\Exception $e) {
            Log::error('Gagal mengambil tabung tersedia', [
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
            Log::error('Gagal mengambil tabung aktif', [
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
