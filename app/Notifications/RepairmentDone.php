<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class RepairmentDone extends Notification
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
            ->id($notification->id)
            ->title('Layanan Bengkel Sepeda Kampus UGM')
            ->icon('/images/bike.png')
            ->body('Perbaikan selesai. Terimakasih telah menggunakan Layanan Bengkel Sepeda Kampus UGM!');
    }
}
