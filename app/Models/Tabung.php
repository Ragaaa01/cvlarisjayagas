<?php

namespace App\Models;

use App\Models\JenisTabung;
use App\Models\StatusTabung;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tabung extends Model
{
    use SoftDeletes;

    protected $table = 'tabungs';

    protected $primaryKey = 'id_tabung';

    protected $fillable = ['kode_tabung', 'id_jenis_tabung', 'id_status_tabung'];

    public function jenisTabung()
    {
        return $this->belongsTo(JenisTabung::class, 'id_jenis_tabung', 'id_jenis_tabung');
    }

    public function statusTabung()
    {
        return $this->belongsTo(StatusTabung::class, 'id_status_tabung', 'id_status_tabung');
    }

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_tabung', 'id_tabung');
    }
}
