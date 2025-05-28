<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifikasiTemplate extends Model
{
    protected $table = 'notifikasi_template';
   protected $primaryKey = 'id_template';

    protected $fillable = ['hari_set', 'nama_template', 'judul', 'isi'];

    public function notifikasis()
    {
        return $this->hasMany(Notifikasi::class, 'id_template');
    }
}
