<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tabung extends Model
{
    protected $table = 'tabungs';
   protected $primaryKey = 'id_tabung';

    protected $fillable = ['kode_tabung', 'id_jenis_tabung', 'id_status_tabung'];

    public function jenisTabung()
    {
        return $this->belongsTo(JenisTabung::class, 'id_jenis_tabung');
    }

    public function statusTabung()
    {
        return $this->belongsTo(StatusTabung::class, 'id_status_tabung');
    }

    public function tabung()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_tabung');
    }
}
