<?php

namespace App\Http\Controllers\WEB;

use App\Models\Akun;
use App\Models\Tabung;
use App\Models\Tagihan;
use App\Models\Transaksi;
use App\Models\Peminjaman;
use App\Models\Perorangan;
use App\Models\Perusahaan;
use App\Models\StatusTabung;
use Illuminate\Http\Request;
use App\Models\JenisTransaksi;
use Illuminate\Support\Carbon;
use App\Models\DetailTransaksi;
use App\Models\StatusTransaksi;
use App\Models\RiwayatTransaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with(['akun', 'perorangan', 'perusahaan', 'statusTransaksi', 'detailTransaksis'])->get();
        return view('admin.pages.transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $akuns = Akun::with('perorangan.perusahaan')
            ->where('role', 'pelanggan')
            ->where('status_aktif', '1')
            ->get();
        $perorangans = Perorangan::with('perusahaan')->get();
        $perusahaans = Perusahaan::all();
        $statusTransaksis = StatusTransaksi::all();
        $tabungs = Tabung::with(['jenisTabung', 'statusTabung'])->whereHas('statusTabung', function ($query) {
            $query->where('status_tabung', 'tersedia');
        })->get();
        $jenisTransaksis = JenisTransaksi::all();
        return view('admin.pages.transaksi.create', compact('akuns', 'perorangans', 'perusahaans', 'statusTransaksis', 'tabungs', 'jenisTransaksis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_akun' => 'nullable|exists:akuns,id_akun',
            'id_perorangan' => 'nullable|exists:perorangans,id_perorangan',
            'total_transaksi' => 'required|numeric|min:0',
            'jumlah_dibayar' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|in:transfer,tunai',
            'detail_transaksi.*.id_tabung' => 'required|exists:tabungs,id_tabung',
            'detail_transaksi.*.id_jenis_transaksi' => 'required|exists:jenis_transaksis,id_jenis_transaksi',
            'detail_transaksi.*.harga' => 'required|numeric|min:0',
        ]);

        // Ambil id_perusahaan dari akun jika ada relasi dengan perusahaan
        $id_perusahaan = null;
        if ($request->id_akun) {
            $akun = Akun::with('perorangan.perusahaan')->find($request->id_akun);
            if ($akun && $akun->perorangan && $akun->perorangan->id_perusahaan) {
                $id_perusahaan = $akun->perorangan->id_perusahaan;
            }
        }

        // Tentukan status transaksi berdasarkan jumlah_dibayar dan total_transaksi
        $status = $request->jumlah_dibayar >= $request->total_transaksi ? 'success' : 'pending';
        $statusTransaksi = StatusTransaksi::where('status', $status)->firstOrFail();
        $id_status_transaksi = $statusTransaksi->id_status_transaksi;

        // Tentukan tanggal transaksi dan tanggal jatuh tempo
        $tanggal_transaksi = Carbon::now('Asia/Jakarta');
        $tanggal_jatuh_tempo = $status === 'pending' ? $tanggal_transaksi->copy()->addDays(30)->toDateString() : null;

        $transaksiData = [
            'id_akun' => $request->id_akun,
            'id_perorangan' => $request->id_perorangan,
            'id_perusahaan' => $id_perusahaan,
            'tanggal_transaksi' => $tanggal_transaksi->toDateString(),
            'waktu_transaksi' => $tanggal_transaksi->toTimeString(),
            'total_transaksi' => $request->total_transaksi,
            'jumlah_dibayar' => $request->jumlah_dibayar,
            'metode_pembayaran' => $request->metode_pembayaran,
            'id_status_transaksi' => $id_status_transaksi,
            'tanggal_jatuh_tempo' => $tanggal_jatuh_tempo,
        ];

        $transaksi = Transaksi::create($transaksiData);

        foreach ($request->detail_transaksi as $detail) {
            // Tentukan batas waktu peminjaman otomatis untuk jenis transaksi "peminjaman"
            $jenisTransaksi = JenisTransaksi::find($detail['id_jenis_transaksi']);
            $batas_waktu_peminjaman = null;
            if ($jenisTransaksi && strtolower(trim($jenisTransaksi->nama_jenis_transaksi)) === 'peminjaman') {
                $batas_waktu_peminjaman = $tanggal_transaksi->copy()->addDays(30)->toDateString();
            }

            $detailTransaksi = DetailTransaksi::create([
                'id_transaksi' => $transaksi->id_transaksi,
                'id_tabung' => $detail['id_tabung'],
                'id_jenis_transaksi' => $detail['id_jenis_transaksi'],
                'harga' => $detail['harga'],
                'batas_waktu_peminjaman' => $batas_waktu_peminjaman,
            ]);

            // Periksa jika jenis transaksi adalah "peminjaman" dan ubah status tabung menjadi "dipinjam"
            if ($jenisTransaksi && strtolower(trim($jenisTransaksi->nama_jenis_transaksi)) === 'peminjaman') {
                $tabung = Tabung::with('statusTabung')->find($detail['id_tabung']);
                if ($tabung && $tabung->statusTabung && $tabung->statusTabung->status_tabung === 'tersedia') {
                    $statusDipinjam = StatusTabung::where('status_tabung', 'dipinjam')->first();
                    if ($statusDipinjam) {
                        $tabung->id_status_tabung = $statusDipinjam->id_status_tabung;
                        if ($tabung->save()) {
                            Log::info('Status tabung dengan ID ' . $tabung->id_tabung . ' berhasil diubah ke dipinjam.');
                        } else {
                            Log::error('Gagal menyimpan perubahan status tabung dengan ID ' . $tabung->id_tabung);
                        }
                    } else {
                        Log::error('Status "dipinjam" tidak ditemukan di tabel status_tabungs.');
                    }
                } else {
                    Log::warning('Tabung dengan ID ' . $detail['id_tabung'] . ' tidak ditemukan atau statusnya bukan "tersedia".');
                }
            } else {
                Log::error('Jenis transaksi dengan ID ' . $detail['id_jenis_transaksi'] . ' tidak ditemukan atau bukan peminjaman.');
            }
        }

        return redirect()->route('transaksis.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function show(Transaksi $transaksi)
    {
        $transaksi->load('akun', 'perorangan', 'perusahaan', 'statusTransaksi', 'detailTransaksis.tabung', 'detailTransaksis.jenisTransaksi');
        return view('admin.pages.transaksi.show', compact('transaksi'));
    }

    public function edit(Transaksi $transaksi)
    {
        $akuns = Akun::with('perorangan.perusahaan')
            ->where('role', 'pelanggan')
            ->where('status_aktif', '1')
            ->get();
        $perorangans = Perorangan::with('perusahaan')->get();
        $perusahaans = Perusahaan::all();
        $statusTransaksis = StatusTransaksi::all();
        $tabungs = Tabung::with(['jenisTabung', 'statusTabung'])->whereHas('statusTabung', function ($query) {
            $query->where('status_tabung', 'tersedia');
        })->get();
        $jenisTransaksis = JenisTransaksi::all();
        $transaksi->load('detailTransaksis');
        return view('admin.pages.transaksi.edit', compact('transaksi', 'akuns', 'perorangans', 'perusahaans', 'statusTransaksis', 'tabungs', 'jenisTransaksis'));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'id_akun' => 'nullable|exists:akuns,id_akun',
            'id_perorangan' => 'nullable|exists:perorangans,id_perorangan',
            'total_transaksi' => 'required|numeric|min:0',
            'jumlah_dibayar' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|in:transfer,tunai',
            'detail_transaksi.*.id_tabung' => 'required|exists:tabungs,id_tabung',
            'detail_transaksi.*.id_jenis_transaksi' => 'required|exists:jenis_transaksis,id_jenis_transaksi',
            'detail_transaksi.*.harga' => 'required|numeric|min:0',
        ]);

        // Ambil id_perusahaan dari akun jika ada relasi dengan perusahaan
        $id_perusahaan = null;
        if ($request->id_akun) {
            $akun = Akun::with('perorangan.perusahaan')->find($request->id_akun);
            if ($akun && $akun->perorangan && $akun->perorangan->id_perusahaan) {
                $id_perusahaan = $akun->perorangan->id_perusahaan;
            }
        }

        // Tentukan status transaksi berdasarkan jumlah_dibayar dan total_transaksi
        $status = $request->jumlah_dibayar >= $request->total_transaksi ? 'success' : 'pending';
        $statusTransaksi = StatusTransaksi::where('status', $status)->firstOrFail();
        $id_status_transaksi = $statusTransaksi->id_status_transaksi;

        // Tentukan tanggal transaksi dan tanggal jatuh tempo
        $tanggal_transaksi = Carbon::now('Asia/Jakarta');
        $tanggal_jatuh_tempo = $status === 'pending' ? $tanggal_transaksi->copy()->addDays(30)->toDateString() : null;

        $transaksi->update([
            'id_akun' => $request->id_akun,
            'id_perorangan' => $request->id_perorangan,
            'id_perusahaan' => $id_perusahaan,
            'tanggal_transaksi' => $tanggal_transaksi->toDateString(),
            'waktu_transaksi' => $tanggal_transaksi->toTimeString(),
            'total_transaksi' => $request->total_transaksi,
            'jumlah_dibayar' => $request->jumlah_dibayar,
            'metode_pembayaran' => $request->metode_pembayaran,
            'id_status_transaksi' => $id_status_transaksi,
            'tanggal_jatuh_tempo' => $tanggal_jatuh_tempo,
        ]);

        $transaksi->detailTransaksis()->delete();
        foreach ($request->detail_transaksi as $detail) {
            // Tentukan batas waktu peminjaman otomatis untuk jenis transaksi "peminjaman"
            $jenisTransaksi = JenisTransaksi::find($detail['id_jenis_transaksi']);
            $batas_waktu_peminjaman = null;
            if ($jenisTransaksi && strtolower(trim($jenisTransaksi->nama_jenis_transaksi)) === 'peminjaman') {
                $batas_waktu_peminjaman = $tanggal_transaksi->copy()->addDays(30)->toDateString();
            }

            $detailTransaksi = DetailTransaksi::create([
                'id_transaksi' => $transaksi->id_transaksi,
                'id_tabung' => $detail['id_tabung'],
                'id_jenis_transaksi' => $detail['id_jenis_transaksi'],
                'harga' => $detail['harga'],
                'batas_waktu_peminjaman' => $batas_waktu_peminjaman,
            ]);

            // Periksa jika jenis transaksi adalah "peminjaman" dan ubah status tabung menjadi "dipinjam"
            if ($jenisTransaksi && strtolower(trim($jenisTransaksi->nama_jenis_transaksi)) === 'peminjaman') {
                $tabung = Tabung::with('statusTabung')->find($detail['id_tabung']);
                if ($tabung && $tabung->statusTabung && $tabung->statusTabung->status_tabung === 'tersedia') {
                    $statusDipinjam = StatusTabung::where('status_tabung', 'dipinjam')->first();
                    if ($statusDipinjam) {
                        $tabung->id_status_tabung = $statusDipinjam->id_status_tabung;
                        if ($tabung->save()) {
                            Log::info('Status tabung dengan ID ' . $tabung->id_tabung . ' berhasil diubah ke dipinjam.');
                        } else {
                            Log::error('Gagal menyimpan perubahan status tabung dengan ID ' . $tabung->id_tabung);
                        }
                    } else {
                        Log::error('Status "dipinjam" tidak ditemukan di tabel status_tabungs.');
                    }
                } else {
                    Log::warning('Tabung dengan ID ' . $detail['id_tabung'] . ' tidak ditemukan atau statusnya bukan "tersedia".');
                }
            } else {
                Log::error('Jenis transaksi dengan ID ' . $detail['id_jenis_transaksi'] . ' tidak ditemukan atau bukan peminjaman.');
            }
        }

        return redirect()->route('transaksis.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();
        return redirect()->route('transaksis.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}