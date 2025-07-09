<?php

namespace App\Http\Controllers\WEB;

use App\Models\Tabung;
use App\Models\Transaksi;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\StatusTabung;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class PengembalianController extends Controller
{
     /**
     * Menampilkan daftar pengembalian
     */
    public function index()
    {
        $pengembalians = Pengembalian::with('peminjaman.detailTransaksi.transaksi')
            ->oldest()
            ->paginate(10);
        return view('admin.pages.pengembalian.index', compact('pengembalians'));
    }

    /**
     * Menyimpan data pengembalian
     */
    public function store(Request $request, Peminjaman $peminjaman)
    {
        // Validasi bahwa peminjaman masih aktif
        if ($peminjaman->status_pinjam !== 'aktif') {
            return redirect()->back()->with('error', 'Peminjaman ini sudah selesai atau tidak valid.');
        }

        // Validasi input dari form
        $request->validate([
            'kondisi_tabung' => 'required|in:baik,rusak',
            'keterangan' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // Buat entri pengembalian
            Pengembalian::create([
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'tanggal_kembali' => Carbon::now('Asia/Jakarta')->toDateString(),
                'kondisi_tabung' => $request->kondisi_tabung,
                'keterangan' => $request->keterangan ?? 'Pengembalian selesai.',
            ]);

            // Ubah status peminjaman menjadi selesai
            $peminjaman->update([
                'status_pinjam' => 'selesai'
            ]);

            // Ubah status tabung berdasarkan kondisi_tabung
            $tabung = Tabung::find($peminjaman->detailTransaksi->id_tabung);
            if ($tabung) {
                $statusTabung = StatusTabung::where('status_tabung', $request->kondisi_tabung === 'baik' ? 'tersedia' : 'rusak')->first();
                if ($statusTabung) {
                    $tabung->id_status_tabung = $statusTabung->id_status_tabung;
                    $tabung->save();
                } else {
                    Log::error('Status tabung "' . ($request->kondisi_tabung === 'baik' ? 'tersedia' : 'rusak') . '" tidak ditemukan di tabel status_tabungs untuk tabung ID ' . $peminjaman->detailTransaksi->id_tabung);
                    throw new \Exception('Status tabung tidak ditemukan.');
                }
            } else {
                Log::error('Tabung dengan ID ' . $peminjaman->detailTransaksi->id_tabung . ' tidak ditemukan.');
                throw new \Exception('Tabung tidak ditemukan.');
            }

            // Cek apakah transaksi terkait bisa dipindahkan ke riwayat
            $transaksi = Transaksi::find($peminjaman->detailTransaksi->id_transaksi);
            if ($transaksi) {
                $transaksi->refresh();
                $controller = new TransaksiController();
                $controller->moveToRiwayat($transaksi);
            } else {
                Log::warning('Transaksi untuk peminjaman ID ' . $peminjaman->id_peminjaman . ' tidak ditemukan.');
            }

            DB::commit();
            return redirect()->route('admin.peminjaman.index')->with('success', 'Pengembalian berhasil dicatat.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal mencatat pengembalian untuk peminjaman ID ' . $peminjaman->id_peminjaman . ': ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mencatat pengembalian: ' . $e->getMessage());
        }
    }
}
