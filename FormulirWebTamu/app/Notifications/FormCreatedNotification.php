<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class FormCreatedNotification extends Notification
{
    use Queueable;

    public $form;
    public $message;

    public function __construct($form, $message)
    {
        $this->form = $form;
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Form Baru Diajukan')
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line($this->message)
            ->action('Lihat Form', url('/secretary/form/' . $this->form->id))
            ->line('Terima kasih.');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->message,
            'form_id' => $this->form->id,
        ];
    }
}
