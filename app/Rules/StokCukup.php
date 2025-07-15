<?php

namespace App\Rules;

use App\Models\JenisTabung;
use App\Models\StatusTabung;
use App\Models\Tabung;
use Illuminate\Contracts\Validation\Rule;

class StokCukup implements Rule
{
    private $id_jenis_tabung;
    private $stokTersedia;
    private $namaJenisTabung;

    /**
     * Rule ini membutuhkan ID jenis tabung untuk bisa mengecek stoknya.
     */
    public function __construct($id_jenis_tabung)
    {
        $this->id_jenis_tabung = $id_jenis_tabung;
    }

    /**
     * Logika utama validasi.
     * Return true jika stok cukup, false jika tidak.
     */
    public function passes($attribute, $value)
    {
        // $value adalah jumlah yang diminta oleh pelanggan
        $jumlahDiminta = (int) $value;

        // Cari ID untuk status 'tersedia'
        $statusTersediaId = StatusTabung::where('status_tabung', 'tersedia')->value('id_status_tabung');

        // Hitung jumlah tabung yang tersedia untuk jenis ini
        $this->stokTersedia = Tabung::where('id_jenis_tabung', $this->id_jenis_tabung)
            ->where('id_status_tabung', $statusTersediaId)
            ->count();

        // Simpan nama jenis untuk pesan error
        $this->namaJenisTabung = JenisTabung::find($this->id_jenis_tabung)->nama_jenis;

        return $jumlahDiminta <= $this->stokTersedia;
    }

    /**
     * Pesan error yang akan ditampilkan jika validasi gagal.
     */
    public function message()
    {
        return "Stok tabung {$this->namaJenisTabung} tidak mencukupi. Stok tersedia: {$this->stokTersedia}.";
    }
}
