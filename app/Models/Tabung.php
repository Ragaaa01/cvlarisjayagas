<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tabung extends Model
{
    protected $table = 'tabungs';
   protected $primaryKey = 'id_tabung';

    protected $fillable = ['kode_tabung', 'id_jenis_tabung', 'id_status_tabung'];

    public function jenis()
    {
        return $this->belongsTo(JenisTabung::class, 'id_jenis_tabung');
    }

    public function status()
    {
        return $this->belongsTo(StatusTabung::class, 'id_status_tabung');
    }

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_tabung');
    }
}
