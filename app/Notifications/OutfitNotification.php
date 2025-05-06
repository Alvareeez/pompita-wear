<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OutfitNotification extends Notification
{
    use Queueable;

    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database']; // Guardar la notificación en la base de datos
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->message,
        ];
    }
}
