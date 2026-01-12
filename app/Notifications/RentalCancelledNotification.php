<?php
// app/Notifications/RentalCancelledNotification.php

namespace App\Notifications;

use App\Models\Rental;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RentalCancelledNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected Rental $rental,
        protected User $bailleur
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $property = $this->rental->property;
        $tenant = $this->rental->tenant;

        $mail = (new MailMessage)
            ->subject('Fin de location')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Votre client ' . $this->bailleur->name . ' a mis fin à une location.')
            ->line('**Bien :** ' . $property->name)
            ->line('**Locataire :** ' . $tenant->full_name)
            ->line('**Date de fin :** ' . now()->format('d/m/Y'));

        if ($this->rental->cancellation_reason) {
            $mail->line('**Motif :** ' . $this->rental->cancellation_reason);
        }

        return $mail
            ->action('Voir les détails', url('/avocat/bailleurs/' . $this->bailleur->id . '/rentals'))
            ->line('Le bien est maintenant disponible.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'rental_cancelled',
            'rental_id' => $this->rental->id,
            'property_name' => $this->rental->property->name,
            'tenant_name' => $this->rental->tenant->full_name,
            'bailleur_id' => $this->bailleur->id,
            'bailleur_name' => $this->bailleur->name,
            'reason' => $this->rental->cancellation_reason,
            'message' => $this->bailleur->name . ' a mis fin à la location de ' . 
                        $this->rental->tenant->full_name . ' pour le bien ' . $this->rental->property->name,
        ];
    }
}