<?php

// namespace App\Http\Controllers\Api;

// use App\Http\Controllers\Controller;
// use App\Http\Requests\StoreApiTransaksiRequest;
// use App\Http\Requests\UpdateApiTransaksiRequest;
// use App\Http\Requests\UpdateTransaksiRequest;
// use App\Http\Resources\ApiTransaksiResource;
// use App\Models\DetailTransaksi;
// use App\Models\Peminjaman;
// use App\Models\Tabung;
// use App\Models\Tagihan;
// use App\Models\Transaksi;
// use Carbon\Carbon;
// use Illuminate\Http\JsonResponse;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Validator;

// class ApiManajemenTransaksiController extends Controller
// {
//     /**
//      * Menampilkan semua transaksi.
//      * @return JsonResponse
//      */
//     public function index(): JsonResponse
//     {
//         try {
//             $transaksis = Transaksi::with(['detailTransaksis', 'tagihan', 'statusTransaksi', 'akun', 'perorangan', 'perusahaan'])->get();
//             return response()->json([
//                 'status' => 'sukses',
//                 'data' => ApiTransaksiResource::collection($transaksis),
//             ], 200);
//         } catch (\Exception $e) {
//             return response()->json([
//                 'status' => 'gagal',
//                 'pesan' => 'Gagal mengambil data transaksi: ' . $e->getMessage(),
//             ], 500);
//         }
//     }

//     /**
//      * Menyimpan transaksi baru.
//      * @param StoreApiTransaksiRequest $request
//      * @return JsonResponse
//      */
//     public function store(StoreTransaksiRequest $request): JsonResponse
//     {
//         try {
//             DB::beginTransaction();

//             // Set tanggal dan waktu transaksi otomatis
//             $tanggalTransaksi = Carbon::now()->format('Y-m-d');
//             $waktuTransaksi = Carbon::now()->format('H:i:s');

//             // Buat transaksi baru
//             $transaksi = Transaksi::create([
//                 'id_akun' => $request->id_akun ?? null,
//                 'id_perorangan' => $request->id_perorangan ?? null,
//                 'id_perusahaan' => $request->id_perusahaan ?? null,
//                 'tanggal_transaksi' => $tanggalTransaksi,
//                 'waktu_transaksi' => $waktuTransaksi,
//                 'total_transaksi' => $request->total_transaksi,
//                 'jumlah_dibayar' => $request->jumlah_dibayar,
//                 'metode_pembayaran' => $request->metode_pembayaran,
//                 'id_status_transaksi' => $request->id_status_transaksi,
//                 // Set jatuh tempo 30 hari jika ada peminjaman
//                 'tanggal_jatuh_tempo' => $this->hasPeminjaman($request->details) ? Carbon::now()->addDays(30)->format('Y-m-d') : null,
//             ]);

//             // Buat detail transaksi
//             foreach ($request->details as $detail) {
//                 $detailTransaksi = $transaksi->detailTransaksis()->create([
//                     'id_tabung' => $detail['id_tabung'],
//                     'id_jenis_transaksi' => $detail['id_jenis_transaksi'],
//                     'harga' => $detail['harga'],
//                     'batas_waktu_peminjaman' => $detail['id_jenis_transaksi'] == 1 ? Carbon::now()->addDays(30)->format('Y-m-d') : null,
//                 ]);

//                 // Jika peminjaman, buat record peminjaman
//                 if ($detail['id_jenis_transaksi'] == 1) {
//                     Peminjaman::create([
//                         'id_detail_transaksi' => $detailTransaksi->id_detail_transaksi,
//                         'tanggal_pinjam' => $tanggalTransaksi,
//                         'status_pinjam' => 'aktif',
//                     ]);
//                     // Update status tabung menjadi dipinjam
//                     Tabung::where('id_tabung', $detail['id_tabung'])->update(['id_status_tabung' => 2]); // 2 = dipinjam
//                 }
//             }

//             // Buat tagihan jika belum lunas
//             $this->tambahTagihan($transaksi->id_transaksi);

//             DB::commit();

//             return response()->json([
//                 'status' => 'sukses',
//                 'pesan' => 'Transaksi berhasil dibuat',
//                 'data' => new ApiTransaksiResource($transaksi->load(['detailTransaksis', 'tagihan', 'statusTransaksi', 'akun', 'perorangan', 'perusahaan'])),
//             ], 201);
//         } catch (\Exception $e) {
//             DB::rollBack();
//             return response()->json([
//                 'status' => 'gagal',
//                 'pesan' => 'Gagal membuat transaksi: ' . $e->getMessage(),
//             ], 500);
//         }
//     }

//     /**
//      * Menampilkan detail transaksi berdasarkan ID.
//      * @param int $id
//      * @return JsonResponse
//      */
//     public function show($id): JsonResponse
//     {
//         try {
//             $transaksi = Transaksi::with(['detailTransaksis', 'tagihan', 'statusTransaksi', 'akun', 'perorangan', 'perusahaan'])->find($id);
//             if (!$transaksi) {
//                 return response()->json([
//                     'status' => 'gagal',
//                     'pesan' => 'Transaksi tidak ditemukan',
//                 ], 404);
//             }
//             return response()->json([
//                 'status' => 'sukses',
//                 'data' => new TransaksiResource($transaksi),
//             ], 200);
//         } catch (\Exception $e) {
//             return response()->json([
//                 'status' => 'gagal',
//                 'pesan' => 'Gagal mengambil detail transaksi: ' . $e->getMessage(),
//             ], 500);
//         }
//     }

//     /**
//      * Memperbarui transaksi.
//      * @param UpdateApiTransaksiRequest $request
//      * @param int $id
//      * @return JsonResponse
//      */
//     public function update(UpdateApiTransaksiRequest $request, $id): JsonResponse
//     {
//         try {
//             DB::beginTransaction();

//             $transaksi = Transaksi::find($id);
//             if (!$transaksi) {
//                 return response()->json([
//                     'status' => 'gagal',
//                     'pesan' => 'Transaksi tidak ditemukan',
//                 ], 404);
//             }

//             // Perbarui transaksi
//             $transaksi->update([
//                 'id_akun' => $request->id_akun ?? $transaksi->id_akun,
//                 'id_perorangan' => $request->id_perorangan ?? $transaksi->id_perorangan,
//                 'id_perusahaan' => $request->id_perusahaan ?? $transaksi->id_perusahaan,
//                 'total_transaksi' => $request->total_transaksi ?? $transaksi->total_transaksi,
//                 'jumlah_dibayar' => $request->jumlah_dibayar ?? $transaksi->jumlah_dibayar,
//                 'metode_pembayaran' => $request->metode_pembayaran ?? $transaksi->metode_pembayaran,
//                 'id_status_transaksi' => $request->id_status_transaksi ?? $transaksi->id_status_transaksi,
//             ]);

//             // Perbarui detail transaksi jika ada
//             if ($request->has('details')) {
//                 $transaksi->detailTransaksis()->delete();
//                 foreach ($request->details as $detail) {
//                     $detailTransaksi = $transaksi->detailTransaksis()->create([
//                         'id_tabung' => $detail['id_tabung'],
//                         'id_jenis_transaksi' => $detail['id_jenis_transaksi'],
//                         'harga' => $detail['harga'],
//                         'batas_waktu_peminjaman' => $detail['id_jenis_transaksi'] == 1 ? Carbon::now()->addDays(30)->format('Y-m-d') : null,
//                     ]);

//                     if ($detail['id_jenis_transaksi'] == 1) {
//                         Peminjaman::create([
//                             'id_detail_transaksi' => $detailTransaksi->id_detail_transaksi,
//                             'tanggal_pinjam' => Carbon::now()->format('Y-m-d'),
//                             'status_pinjam' => 'aktif',
//                         ]);
//                         Tabung::where('id_tabung', $detail['id_tabung'])->update(['id_status_tabung' => 2]);
//                     }
//                 }
//                 // Update jatuh tempo jika ada peminjaman
//                 $transaksi->update([
//                     'tanggal_jatuh_tempo' => $this->hasPeminjaman($request->details) ? Carbon::now()->addDays(30)->format('Y-m-d') : null,
//                 ]);
//             }

//             // Perbarui tagihan
//             $this->tambahTagihan($transaksi->id_transaksi);

//             DB::commit();

//             return response()->json([
//                 'status' => 'sukses',
//                 'pesan' => 'Transaksi berhasil diperbarui',
//                 'data' => new TransaksiResource($transaksi->load(['detailTransaksis', 'tagihan', 'statusTransaksi', 'akun', 'perorangan', 'perusahaan'])),
//             ], 200);
//         } catch (\Exception $e) {
//             DB::rollBack();
//             return response()->json([
//                 'status' => 'gagal',
//                 'pesan' => 'Gagal memperbarui transaksi: ' . $e->getMessage(),
//             ], 500);
//         }
//     }

//     /**
//      * Menghapus transaksi (soft delete).
//      * @param int $id
//      * @return JsonResponse
//      */
//     public function destroy($id): JsonResponse
//     {
//         try {
//             DB::beginTransaction();

//             $transaksi = Transaksi::find($id);
//             if (!$transaksi) {
//                 return response()->json([
//                     'status' => 'gagal',
//                     'pesan' => 'Transaksi tidak ditemukan',
//                 ], 404);
//             }

//             $transaksi->delete();

//             DB::commit();

//             return response()->json([
//                 'status' => 'sukses',
//                 'pesan' => 'Transaksi berhasil dihapus',
//             ], 200);
//         } catch (\Exception $e) {
//             DB::rollBack();
//             return response()->json([
//                 'status' => 'gagal',
//                 'pesan' => 'Gagal menghapus transaksi: ' . $e->getMessage(),
//             ], 500);
//         }
//     }

//     /**
//      * Menambahkan tagihan untuk transaksi belum lunas.
//      * @param int $id
//      * @return JsonResponse
//      */
//     public function tambahTagihan($id): JsonResponse
//     {
//         try {
//             DB::beginTransaction();

//             $transaksi = Transaksi::find($id);
//             if (!$transaksi) {
//                 return response()->json([
//                     'status' => 'gagal',
//                     'pesan' => 'Transaksi tidak ditemukan',
//                 ], 404);
//             }

//             $sisa = $transaksi->total_transaksi - $transaksi->jumlah_dibayar;
//             if ($sisa <= 0) {
//                 Tagihan::where('id_transaksi', $transaksi->id_transaksi)->update(['status' => 'lunas']);
//                 return response()->json([
//                     'status' => 'sukses',
//                     'pesan' => 'Transaksi sudah lunas',
//                 ], 200);
//             }

//             $tagihan = Tagihan::updateOrCreate(
//                 ['id_transaksi' => $transaksi->id_transaksi],
//                 [
//                     'jumlah_dibayar' => $transaksi->jumlah_dibayar,
//                     'sisa' => $sisa,
//                     'status' => 'belum_lunas',
//                     'hari_keterlambatan' => $this->hitungKeterlambatan($transaksi),
//                     'periode_ke' => $this->hitungPeriode($transaksi),
//                     'tanggal_bayar_tagihan' => $sisa == 0 ? Carbon::now()->format('Y-m-d') : null,
//                 ]
//             );

//             DB::commit();

//             return response()->json([
//                 'status' => 'sukses',
//                 'pesan' => 'Tagihan berhasil ditambahkan',
//                 'data' => $tagihan,
//             ], 200);
//         } catch (\Exception $e) {
//             DB::rollBack();
//             return response()->json([
//                 'status' => 'gagal',
//                 'pesan' => 'Gagal menambahkan tagihan: ' . $e->getMessage(),
//             ], 500);
//         }
//     }

//     /**
//      * Menghitung denda dan jatuh tempo.
//      * @param int $id
//      * @return JsonResponse
//      */
//     public function hitungDenda($id): JsonResponse
//     {
//         try {
//             $transaksi = Transaksi::find($id);
//             if (!$transaksi || !$transaksi->tanggal_jatuh_tempo) {
//                 return response()->json([
//                     'status' => 'gagal',
//                     'pesan' => 'Transaksi tidak ditemukan atau tidak ada jatuh tempo',
//                 ], 404);
//             }

//             $keterlambatan = $this->hitungKeterlambatan($transaksi);
//             $denda = $keterlambatan > 0 ? 70000 : 0;

//             return response()->json([
//                 'status' => 'sukses',
//                 'data' => [
//                     'id_transaksi' => $transaksi->id_transaksi,
//                     'hari_keterlambatan' => $keterlambatan,
//                     'denda' => $denda,
//                     'tanggal_jatuh_tempo' => $transaksi->tanggal_jatuh_tempo,
//                 ],
//             ], 200);
//         } catch (\Exception $e) {
//             return response()->json([
//                 'status' => 'gagal',
//                 'pesan' => 'Gagal menghitung denda: ' . $e->getMessage(),
//             ], 500);
//         }
//     }

//     /**
//      * Validasi kode tabung (QR atau manual).
//      * @return JsonResponse
//      */
//     public function validasiTabung(): JsonResponse
//     {
//         try {
//             $validator = Validator::make(request()->all(), [
//                 'kode_tabung' => 'required|string|exists:tabungs,kode_tabung',
//             ], [
//                 'kode_tabung.required' => 'Kode tabung wajib diisi.',
//                 'kode_tabung.exists' => 'Kode tabung tidak ditemukan.',
//             ]);

//             if ($validator->fails()) {
//                 return response()->json([
//                     'status' => 'gagal',
//                     'pesan' => $validator->errors()->first(),
//                 ], 422);
//             }

//             $tabung = Tabung::where('kode_tabung', request()->kode_tabung)->first();
//             if ($tabung->id_status_tabung != 1) { // 1 = tersedia
//                 return response()->json([
//                     'status' => 'gagal',
//                     'pesan' => 'Tabung tidak tersedia untuk transaksi.',
//                 ], 400);
//             }

//             return response()->json([
//                 'status' => 'sukses',
//                 'data' => [
//                     'id_tabung' => $tabung->id_tabung,
//                     'kode_tabung' => $tabung->kode_tabung,
//                     'nama_jenis' => $tabung->jenisTabung->nama_jenis,
//                     'harga' => $tabung->jenisTabung->harga,
//                     'opsi_transaksi' => [
//                         ['id_jenis_transaksi' => 1, 'nama' => 'peminjaman'],
//                         ['id_jenis_transaksi' => 2, 'nama' => 'isi ulang'],
//                     ],
//                 ],
//             ], 200);
//         } catch (\Exception $e) {
//             return response()->json([
//                 'status' => 'gagal',
//                 'pesan' => 'Gagal memvalidasi tabung: ' . $e->getMessage(),
//             ], 500);
//         }
//     }

//     /**
//      * Menghitung hari keterlambatan.
//      * @param \App\Models\Transaksi $transaksi
//      * @return int
//      */
//     private function hitungKeterlambatan($transaksi)
//     {
//         if (!$transaksi->tanggal_jatuh_tempo) {
//             return 0;
//         }
//         $jatuhTempo = Carbon::parse($transaksi->tanggal_jatuh_tempo);
//         $sekarang = Carbon::now();
//         return max(0, $sekarang->diffInDays($jatuhTempo, false));
//     }

//     /**
//      * Menghitung periode tagihan.
//      * @param \App\Models\Transaksi $transaksi
//      * @return int
//      */
//     private function hitungPeriode($transaksi)
//     {
//         $keterlambatan = $this->hitungKeterlambatan($transaksi);
//         return $keterlambatan > 0 ? ceil($keterlambatan / 30) : 1;
//     }

//     /**
//      * Mengecek apakah ada peminjaman dalam detail transaksi.
//      * @param array $details
//      * @return bool
//      */
//     private function hasPeminjaman($details)
//     {
//         foreach ($details as $detail) {
//             if ($detail['id_jenis_transaksi'] == 1) {
//                 return true;
//             }
//         }
//         return false;
//     }
// }
