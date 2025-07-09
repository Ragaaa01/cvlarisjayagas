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
        $transaksis = Transaksi::with(['akun', 'perorangan', 'perusahaan', 'statusTransaksi', 'detailTransaksis'])
            ->oldest()
            ->paginate(10);
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
        $tabungs = Tabung::with(['jenisTabung', 'statusTabung'])->get();
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
            'detail_transaksi.*.batas_waktu_peminjaman' => 'nullable|date|after_or_equal:tanggal_transaksi',
        ], [
            'id_akun.nullable' => 'Pilih minimal salah satu akun atau perorangan.',
            'id_perorangan.nullable' => 'Pilih minimal salah satu akun atau perorangan.',
            'total_transaksi.required' => 'Total transaksi wajib diisi.',
            'total_transaksi.numeric' => 'Total transaksi harus berupa angka.',
            'total_transaksi.min' => 'Total transaksi tidak boleh kurang dari 0.',
            'jumlah_dibayar.required' => 'Jumlah dibayar wajib diisi.',
            'jumlah_dibayar.numeric' => 'Jumlah dibayar harus berupa angka.',
            'jumlah_dibayar.min' => 'Jumlah dibayar tidak boleh kurang dari 0.',
            'metode_pembayaran.required' => 'Metode pembayaran wajib dipilih.',
            'metode_pembayaran.in' => 'Metode pembayaran harus berupa tunai atau transfer.',
            'detail_transaksi.*.id_tabung.required' => 'Tabung wajib dipilih untuk setiap detail transaksi.',
            'detail_transaksi.*.id_tabung.exists' => 'Tabung yang dipilih tidak valid.',
            'detail_transaksi.*.id_jenis_transaksi.required' => 'Jenis transaksi wajib dipilih untuk setiap detail transaksi.',
            'detail_transaksi.*.id_jenis_transaksi.exists' => 'Jenis transaksi yang dipilih tidak valid.',
            'detail_transaksi.*.harga.required' => 'Harga wajib diisi untuk setiap detail transaksi.',
            'detail_transaksi.*.harga.numeric' => 'Harga harus berupa angka.',
            'detail_transaksi.*.harga.min' => 'Harga tidak boleh kurang dari 0.',
            'detail_transaksi.*.batas_waktu_peminjaman.date' => 'Batas waktu peminjaman harus berupa tanggal yang valid.',
            'detail_transaksi.*.batas_waktu_peminjaman.after_or_equal' => 'Batas waktu peminjaman harus setelah atau sama dengan tanggal transaksi.',
        ]);

        if (!$request->id_akun && !$request->id_perorangan) {
            return redirect()->back()->withErrors(['id_akun' => 'Pilih minimal salah satu akun atau perorangan.'])->withInput();
        }

        DB::beginTransaction();

        try {
            // Validasi tabung untuk peminjaman harus 'tersedia'
            foreach ($request->detail_transaksi as $index => $detail) {
                $jenisTransaksi = JenisTransaksi::find($detail['id_jenis_transaksi']);
                if ($jenisTransaksi && strtolower(trim($jenisTransaksi->nama_jenis_transaksi)) === 'peminjaman') {
                    $tabung = Tabung::find($detail['id_tabung']);
                    if (!$tabung) {
                        return redirect()->back()->withErrors(['detail_transaksi.' . $index . '.id_tabung' => 'Tabung dengan ID ' . $detail['id_tabung'] . ' tidak ditemukan.'])->withInput();
                    }
                    if ($tabung->statusTabung->status_tabung !== 'tersedia') {
                        return redirect()->back()->withErrors(['detail_transaksi.' . $index . '.id_tabung' => 'Tabung untuk peminjaman harus berstatus tersedia.'])->withInput();
                    }
                }
            }

            $id_perusahaan = null;
            if ($request->id_akun) {
                $akun = Akun::with('perorangan.perusahaan')->find($request->id_akun);
                if ($akun && $akun->perorangan) {
                    $request->merge(['id_perorangan' => $akun->id_perorangan]);
                    $id_perusahaan = $akun->perorangan->id_perusahaan;
                }
            }

            $status = $request->jumlah_dibayar >= $request->total_transaksi ? 'success' : 'pending';
            $statusTransaksi = StatusTransaksi::where('status', $status)->firstOrFail();
            $id_status_transaksi = $statusTransaksi->id_status_transaksi;

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
                $jenisTransaksi = JenisTransaksi::find($detail['id_jenis_transaksi']);
                $batas_waktu_peminjaman = null;
                if ($jenisTransaksi && strtolower(trim($jenisTransaksi->nama_jenis_transaksi)) === 'peminjaman') {
                    $batas_waktu_peminjaman = $detail['batas_waktu_peminjaman'] ?? $tanggal_transaksi->copy()->addDays(30)->toDateString();
                }

                $detailTransaksi = DetailTransaksi::create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'id_tabung' => $detail['id_tabung'],
                    'id_jenis_transaksi' => $detail['id_jenis_transaksi'],
                    'harga' => $detail['harga'],
                    'batas_waktu_peminjaman' => $batas_waktu_peminjaman,
                ]);

                if ($jenisTransaksi && strtolower(trim($jenisTransaksi->nama_jenis_transaksi)) === 'peminjaman') {
                    Peminjaman::create([
                        'id_detail_transaksi' => $detailTransaksi->id_detail_transaksi,
                        'tanggal_pinjam' => $transaksi->tanggal_transaksi,
                        'status_pinjam' => 'aktif',
                    ]);

                    $tabung = Tabung::find($detail['id_tabung']);
                    if ($tabung) {
                        $statusDipinjam = StatusTabung::where('status_tabung', 'dipinjam')->first();
                        if ($statusDipinjam) {
                            $tabung->id_status_tabung = $statusDipinjam->id_status_tabung;
                            $tabung->save();
                        } else {
                            Log::error('Status tabung "dipinjam" tidak ditemukan di tabel status_tabungs untuk tabung ID ' . $detail['id_tabung']);
                            throw new \Exception('Status tabung "dipinjam" tidak ditemukan.');
                        }
                    } else {
                        Log::error('Tabung dengan ID ' . $detail['id_tabung'] . ' tidak ditemukan.');
                        throw new \Exception('Tabung dengan ID ' . $detail['id_tabung'] . ' tidak ditemukan.');
                    }
                }
            }

            // Buat tagihan jika belum lunas
            if ($status === 'pending' || $request->jumlah_dibayar < $request->total_transaksi) {
                Tagihan::create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'jumlah_dibayar' => $request->jumlah_dibayar,
                    'sisa' => $request->total_transaksi - $request->jumlah_dibayar,
                    'status' => ($request->jumlah_dibayar >= $request->total_transaksi) ? 'lunas' : 'belum_lunas',
                    'tanggal_bayar_tagihan' => null,
                    'hari_keterlambatan' => 0,
                    'periode_ke' => 1,
                    'keterangan' => 'Tagihan dibuat otomatis karena transaksi belum lunas.',
                ]);
            }

            // Pindahkan ke riwayat jika transaksi lunas dan tidak ada peminjaman aktif
            if ($status === 'success') {
                $this->moveToRiwayat($transaksi);
            }

            DB::commit();
            return redirect()->route('transaksis.index')->with('success', 'Transaksi berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan transaksi: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Transaksi $transaksi)
    {
        $transaksi->load('akun', 'perorangan', 'perusahaan', 'statusTransaksi', 'detailTransaksis.tabung', 'detailTransaksis.jenisTransaksi');
        return view('admin.pages.transaksi.show', compact('transaksi'));
    }

    public function moveToRiwayat(Transaksi $transaksi)
    {
        // Cek apakah transaksi sudah ada di riwayat
        $existingRiwayat = RiwayatTransaksi::where('id_transaksi', $transaksi->id_transaksi)->first();
        if ($existingRiwayat) {
            Log::info('Transaksi dengan ID ' . $transaksi->id_transaksi . ' sudah ada di riwayat_transaksis.');
            return;
        }

        // Refresh transaksi untuk memastikan data terbaru
        $transaksi->refresh();

        // Cek status transaksi
        $statusTransaksi = StatusTransaksi::find($transaksi->id_status_transaksi);
        if (!$statusTransaksi || $statusTransaksi->status !== 'success') {
            Log::info('Transaksi dengan ID ' . $transaksi->id_transaksi . ' tidak dipindahkan karena status bukan success. Status saat ini: ' . ($statusTransaksi ? $statusTransaksi->status : 'tidak ditemukan') . ', jumlah_dibayar: ' . $transaksi->jumlah_dibayar . ', total_transaksi: ' . $transaksi->total_transaksi);
            return;
        }

        // Cek apakah ada peminjaman aktif
        $hasActivePeminjaman = $transaksi->detailTransaksis()
            ->whereHas('peminjaman', function ($query) {
                $query->where('status_pinjam', 'aktif');
            })->exists();

        if ($hasActivePeminjaman) {
            Log::info('Transaksi dengan ID ' . $transaksi->id_transaksi . ' tidak dipindahkan ke riwayat karena masih ada peminjaman aktif.');
            return;
        }

        // Cek apakah ada tagihan yang belum lunas
        $hasUnpaidTagihan = Tagihan::where('id_transaksi', $transaksi->id_transaksi)
            ->where('status', 'belum_lunas')
            ->exists();

        if ($hasUnpaidTagihan) {
            Log::info('Transaksi dengan ID ' . $transaksi->id_transaksi . ' tidak dipindahkan ke riwayat karena masih ada tagihan belum lunas.');
            return;
        }

        // Hitung durasi peminjaman (jika ada)
        $durasiPeminjaman = null;
        $peminjaman = $transaksi->detailTransaksis()->whereHas('peminjaman')->first();
        if ($peminjaman && $peminjaman->peminjaman && $peminjaman->peminjaman->pengembalian) {
            $tanggalPinjam = Carbon::parse($peminjaman->peminjaman->tanggal_pinjam);
            $tanggalKembali = Carbon::parse($peminjaman->peminjaman->pengembalian->tanggal_kembali);
            $durasiPeminjaman = $tanggalPinjam->diffInDays($tanggalKembali);
        }

        // Simpan ke riwayat
        try {
            RiwayatTransaksi::create([
                'id_transaksi' => $transaksi->id_transaksi,
                'id_akun' => $transaksi->id_akun,
                'id_perorangan' => $transaksi->id_perorangan,
                'id_perusahaan' => $transaksi->id_perusahaan,
                'tanggal_transaksi' => $transaksi->tanggal_transaksi,
                'total_transaksi' => $transaksi->total_transaksi,
                'jumlah_dibayar' => $transaksi->jumlah_dibayar,
                'metode_pembayaran' => $transaksi->metode_pembayaran,
                'tanggal_jatuh_tempo' => $transaksi->tanggal_jatuh_tempo,
                'tanggal_selesai' => Carbon::now('Asia/Jakarta')->toDateString(),
                'status_akhir' => 'success',
                'total_pembayaran' => $transaksi->jumlah_dibayar,
                'denda' => 0,
                'durasi_peminjaman' => $durasiPeminjaman,
                'keterangan' => 'Transaksi selesai dan dipindahkan ke riwayat.',
            ]);

            Log::info('Data transaksi dengan ID ' . $transaksi->id_transaksi . ' berhasil disimpan ke riwayat_transaksis.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan transaksi ID ' . $transaksi->id_transaksi . ' ke riwayat_transaksis: ' . $e->getMessage());
        }
    }

    public function updateTagihanStatus(Tagihan $tagihan)
    {
        $transaksi = $tagihan->transaksi;
        if (!$transaksi) {
            Log::error('Transaksi untuk tagihan ID ' . $tagihan->id_tagihan . ' tidak ditemukan.');
            return;
        }

        $transaksi->refresh();
        $totalTagihan = Tagihan::where('id_transaksi', $transaksi->id_transaksi)->sum('sisa');
        if ($totalTagihan <= 0) {
            $statusTransaksi = StatusTransaksi::where('status', 'success')->firstOrFail();
            $transaksi->id_status_transaksi = $statusTransaksi->id_status_transaksi;
            $transaksi->jumlah_dibayar = $transaksi->total_transaksi;
            $transaksi->tanggal_jatuh_tempo = null;
            $transaksi->save();

            Log::info('Status transaksi ID ' . $transaksi->id_transaksi . ' diperbarui ke success karena tagihan lunas.');
            $this->moveToRiwayat($transaksi);
        }
    }
}