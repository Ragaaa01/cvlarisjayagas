<?php

namespace App\Notifications;

use App\Models\NotifikasiTemplate;
use App\Models\Tagihan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

class JatuhTempoNotification extends Notification
{
    use Queueable;

    protected $tagihan;
    protected $template;

    public function __construct(Tagihan $tagihan, NotifikasiTemplate $template)
    {
        $this->tagihan = $tagihan;
        $this->template = $template;
    }

    /**
     * Tentukan channel pengiriman notifikasi.
     */
    public function via($notifiable): array
    {
        return [FcmChannel::class];
    }

    /**
     * Get the FCM representation of the notification.
     * Menggunakan sintaks baru yang lebih ringkas dan modern.
     */
    public function toFcm(object $notifiable): FcmMessage
    {
        // Ganti placeholder di dalam template dengan data yang relevan
        $isiPesan = str_replace('{id_transaksi}', (string)$this->tagihan->id_transaksi, $this->template->isi);

        return (new FcmMessage(notification: new FcmNotification(
            title: $this->template->judul,
            body: $isiPesan
        )))
            ->data(['id_transaksi' => (string)$this->tagihan->id_transaksi])
            ->custom([
                'android' => [
                    'notification' => [
                        'channel_id' => 'high_importance_channel',
                    ],
                    'priority' => 'high',
                ],
                'apns' => [
                    'payload' => [
                        'aps' => [
                            'sound' => 'default',
                        ],
                    ],
                ],
            ]);
    }
}
