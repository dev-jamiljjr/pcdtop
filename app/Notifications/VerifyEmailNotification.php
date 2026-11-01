<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailNotification extends VerifyEmail
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Verifique Seu Endereço de E-mail - PCD TOP')
            ->greeting('Olá!')
            ->line('Por favor, clique no botão abaixo para verificar seu endereço de e-mail.')
            ->action('Verificar Endereço de E-mail', $verificationUrl)
            ->line('Se você não criou uma conta, nenhuma ação adicional é necessária.')
            ->salutation('Atenciosamente, Equipe PCD TOP');
    }
}
