<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class RepairmentOnProgress extends Notification
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        return WebPushMessage::create()
            ->title('Layanan Bengkel Sepeda Kampus UGM')
            ->icon('/images/bike.png')
            ->body('Laporan anda tengah kami tindak lanjuti. Petugas kami akan segera mendatangi anda.');
    }
}
