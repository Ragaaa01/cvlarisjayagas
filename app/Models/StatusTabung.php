<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusTabung extends Model
{
    protected $table = 'status_tabungs';

    protected $primaryKey = 'id_status_tabung';

    protected $fillable = ['status_tabung'];

    public const TERSEDIA = 1;
    public const DIPINJAM = 2;
    public const RUSAK = 3;
    public const HILANG = 4;

    public function tabungs()
    {
        return $this->hasMany(Tabung::class, 'id_status_tabung');
    }
}
