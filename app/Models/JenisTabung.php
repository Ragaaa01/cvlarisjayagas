<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisTabung extends Model
{
    protected $table = 'jenis_tabungs';
     protected $primaryKey = 'id_jenis_tabung';

    protected $fillable = ['kode_jenis', 'nama_jenis', 'harga'];

    public function tabungs()
    {
        return $this->hasMany(Tabung::class, 'id_jenis_tabung');
    }
}
