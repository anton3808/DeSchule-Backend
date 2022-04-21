<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification
{
    protected $token;
    protected $email;

    public function __construct($token,$email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Ваше посилання для скидання пароля')
            ->line('Ви отримали цей електронний лист, оскільки ми отримали запит на скидання пароля для вашого облікового запису.')
            ->action('Скинути пароль', url('reset-password', $this->token)."/".str_replace("@","29gnmLTv686QsnV",$this->email))
            ->line('Якщо ви не запитували скидання пароля, не потрібно нічого робити.');
    }
}
