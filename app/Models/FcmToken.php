<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use NotificationChannels\Fcm\FcmChannel;

class FcmToken extends Model
{
    use HasFactory;

    protected $table = 'fcm_tokens';
    protected $primaryKey = 'id_fcm_token';

    protected $fillable = ['id_akun', 'token', 'nama_perangkat'];

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'id_akun', 'id_akun');
    }

    public function via($notifiable)
    {
        return [FcmChannel::class];
    }
}
