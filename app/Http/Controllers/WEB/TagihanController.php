<?php

namespace App\Http\Controllers\WEB;

use App\Models\Tagihan;
use App\Models\Transaksi;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\StatusTabung;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\StatusTransaksi;
use App\Models\RiwayatTransaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class TagihanController extends Controller
{
    /**
     * Menampilkan daftar tagihan, dipisahkan menjadi lunas dan belum lunas
     */
    public function index()
    {
        $tagihansBelumLunas = Tagihan::with(['transaksi', 'transaksi.statusTransaksi'])
            ->where('status', 'belum_lunas')
            ->oldest()
            ->get();

        foreach ($tagihansBelumLunas as $tagihan) {
            $tagihan->calculateLateDaysAndPeriod();
        }

        $tagihansBelumLunas = Tagihan::where('status', 'belum_lunas')
            ->oldest()
            ->paginate(10, ['*'], 'belumLunasPage');

        $tagihansLunas = Tagihan::with(['transaksi', 'transaksi.statusTransaksi'])
            ->where('status', 'lunas')
            ->oldest()
            ->get();

        foreach ($tagihansLunas as $tagihan) {
            $tagihan->calculateLateDaysAndPeriod();
        }

        $tagihansLunas = Tagihan::where('status', 'lunas')
            ->oldest()
            ->paginate(10, ['*'], 'lunasPage');

        return view('admin.pages.tagihan.index', compact('tagihansBelumLunas', 'tagihansLunas'));
    }

    /**
     * Menampilkan detail tagihan
     */
    public function show($id)
    {
        $tagihan = Tagihan::with([
            'transaksi',
            'transaksi.perorangan',
            'transaksi.perusahaan',
            'transaksi.akun'
        ])->findOrFail($id);

        $tagihan->calculateLateDaysAndPeriod();

        return view('admin.pages.tagihan.show', compact('tagihan'));
    }

    /**
     * Menangani pembayaran tagihan
     */
    public function pay(Request $request, $id)
    {
        $request->validate([
            'jumlah_bayar' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|in:tunai,transfer',
        ], [
            'jumlah_bayar.required' => 'Jumlah bayar wajib diisi.',
            'jumlah_bayar.numeric' => 'Jumlah bayar harus berupa angka.',
            'jumlah_bayar.min' => 'Jumlah bayar tidak boleh kurang dari 0.',
            'metode_pembayaran.required' => 'Metode pembayaran wajib dipilih.',
            'metode_pembayaran.in' => 'Metode pembayaran harus berupa tunai atau transfer.',
        ]);

        DB::beginTransaction();

        try {
            $tagihan = Tagihan::findOrFail($id);
            $transaksi = Transaksi::findOrFail($tagihan->id_transaksi);

            $jumlah_bayar = $request->jumlah_bayar;
            $total_dibayar = $tagihan->jumlah_dibayar + $jumlah_bayar;
            $sisa = $tagihan->sisa - $jumlah_bayar;

            if ($sisa < 0) {
                return response()->json([
                    'message' => 'Jumlah pembayaran melebihi sisa tagihan.',
                    'errors' => ['jumlah_bayar' => 'Jumlah pembayaran melebihi sisa tagihan.']
                ], 422);
            }

            $riwayat_pembayaran = $tagihan->keterangan ? json_decode($tagihan->keterangan, true) : [];
            if (!is_array($riwayat_pembayaran)) {
                $riwayat_pembayaran = [];
            }

            $riwayat_pembayaran[] = [
                'jumlah_bayar' => $jumlah_bayar,
                'metode_pembayaran' => $request->metode_pembayaran,
                'tanggal_pembayaran' => Carbon::now('Asia/Jakarta')->toDateString(),
            ];

            $tagihan->update([
                'jumlah_dibayar' => $total_dibayar,
                'sisa' => $sisa,
                'status' => $sisa <= 0 ? 'lunas' : 'belum_lunas',
                'tanggal_bayar_tagihan' => $sisa <= 0 ? Carbon::now('Asia/Jakarta')->toDateString() : $tagihan->tanggal_bayar_tagihan,
                'keterangan' => json_encode($riwayat_pembayaran),
            ]);

            $tagihan->calculateLateDaysAndPeriod();

            $transaksi->jumlah_dibayar = $transaksi->jumlah_dibayar + $jumlah_bayar;
            $status = $transaksi->jumlah_dibayar >= $transaksi->total_transaksi ? 'success' : 'pending';
            $statusTransaksi = StatusTransaksi::where('status', $status)->firstOrFail();
            $transaksi->id_status_transaksi = $statusTransaksi->id_status_transaksi;
            $transaksi->metode_pembayaran = $request->metode_pembayaran;
            if ($sisa <= 0) {
                $transaksi->tanggal_jatuh_tempo = null;
            }
            $transaksi->save();

            Log::info('Pembayaran tagihan ID ' . $tagihan->id_tagihan . ' selesai. Status transaksi ID ' . $transaksi->id_transaksi . ': ' . $status . ', jumlah_dibayar: ' . $transaksi->jumlah_dibayar . ', total_transaksi: ' . $transaksi->total_transaksi);

            // Panggil updateTagihanStatus dari TransaksiController
            $transaksiController = new TransaksiController();
            $transaksiController->updateTagihanStatus($tagihan);

            DB::commit();
            return response()->json([
                'message' => 'Pembayaran tagihan berhasil.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal memproses pembayaran tagihan ID ' . $id . ': ' . $e->getMessage());
            return response()->json([
                'message' => 'Gagal memproses pembayaran: ' . $e->getMessage(),
                'errors' => ['general' => 'Terjadi kesalahan saat memproses pembayaran.']
            ], 500);
        }
    }

    /**
     * Menandai peminjaman selesai dan memeriksa apakah transaksi bisa dipindahkan ke riwayat
     */
    public function completePeminjaman(Request $request, $id_peminjaman)
    {
        $request->validate([
            'tanggal_kembali' => 'required|date',
            'kondisi_tabung' => 'required|in:baik,rusak',
            'keterangan' => 'nullable|string',
        ], [
            'tanggal_kembali.required' => 'Tanggal kembali wajib diisi.',
            'tanggal_kembali.date' => 'Tanggal kembali harus berupa tanggal yang valid.',
            'kondisi_tabung.required' => 'Kondisi tabung wajib dipilih.',
            'kondisi_tabung.in' => 'Kondisi tabung harus baik atau rusak.',
        ]);

        DB::beginTransaction();

        try {
            $peminjaman = Peminjaman::findOrFail($id_peminjaman);
            $detailTransaksi = $peminjaman->detailTransaksi;
            $transaksi = $detailTransaksi->transaksi;

            if ($peminjaman->status_pinjam === 'selesai') {
                DB::rollBack();
                return response()->json([
                    'message' => 'Peminjaman sudah selesai.',
                    'errors' => ['general' => 'Peminjaman sudah ditandai selesai.']
                ], 422);
            }

            $peminjaman->update([
                'status_pinjam' => 'selesai',
            ]);

            Pengembalian::create([
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'tanggal_kembali' => Carbon::parse($request->tanggal_kembali)->toDateString(),
                'kondisi_tabung' => $request->kondisi_tabung,
                'keterangan' => $request->keterangan ?? 'Pengembalian selesai.',
            ]);

            $tabung = $detailTransaksi->tabung;
            $statusTabung = StatusTabung::where('status_tabung', $request->kondisi_tabung === 'baik' ? 'tersedia' : 'rusak')->firstOrFail();
            $tabung->update([
                'id_status_tabung' => $statusTabung->id_status_tabung,
            ]);

            Log::info('Peminjaman ID ' . $peminjaman->id_peminjaman . ' selesai. Memeriksa transaksi ID ' . $transaksi->id_transaksi . ' untuk riwayat.');

            $transaksi->refresh();
            $transaksiController = new TransaksiController();
            $transaksiController->moveToRiwayat($transaksi);

            DB::commit();
            return response()->json([
                'message' => 'Peminjaman selesai dan transaksi diperiksa untuk riwayat.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyelesaikan peminjaman ID ' . $id_peminjaman . ': ' . $e->getMessage());
            return response()->json([
                'message' => 'Gagal menyelesaikan peminjaman: ' . $e->getMessage(),
                'errors' => ['general' => 'Terjadi kesalahan saat menyelesaikan peminjaman.']
            ], 500);
        }
    }
}


