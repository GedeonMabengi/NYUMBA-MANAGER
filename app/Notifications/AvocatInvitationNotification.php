<?php
// app/Notifications/AvocatInvitationNotification.php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AvocatInvitationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected User $bailleur,
        protected string $temporaryPassword
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Invitation à rejoindre la plateforme de gestion immobilière')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line($this->bailleur->name . ' vous a ajouté comme avocat sur sa plateforme de gestion immobilière.')
            ->line('Vous pouvez désormais suivre les événements liés à ses biens immobiliers.')
            ->line('Voici vos identifiants de connexion :')
            ->line('**Email :** ' . $notifiable->email)
            ->line('**Mot de passe temporaire :** ' . $this->temporaryPassword)
            ->action('Se connecter', url('/login'))
            ->line('Nous vous recommandons de changer votre mot de passe après votre première connexion.');
    }
}