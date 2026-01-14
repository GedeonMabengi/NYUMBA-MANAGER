<?php
// app/Notifications/RentalCreatedNotification.php

namespace App\Notifications;

use App\Models\Rental;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RentalCreatedNotification extends Notification implements ShouldQueue
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

        return (new MailMessage)
            ->subject('Nouvelle attribution de locataire')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Votre client ' . $this->bailleur->name . ' a attribué un locataire à un bien.')
            ->line('**Bien :** ' . $property->name)
            ->line('**Locataire :** ' . $tenant->full_name)
            ->line('**Date de début :** ' . $this->rental->start_date->format('d/m/Y'))
            ->line('**Loyer :** ' . number_format($this->rental->rent_amount, 2, ',', ' ') . ' $')
            ->action('Voir le contrat', url('/avocat/bailleurs/' . $this->bailleur->id . '/rentals'))
            ->line('Un contrat de bail a été uploadé dans le système.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'rental_created',
            'rental_id' => $this->rental->id,
            'property_name' => $this->rental->property->name,
            'tenant_name' => $this->rental->tenant->full_name,
            'bailleur_id' => $this->bailleur->id,
            'bailleur_name' => $this->bailleur->name,
            'message' => $this->bailleur->name . ' a attribué ' . $this->rental->tenant->full_name . 
                        ' au bien ' . $this->rental->property->name,
        ];
    }
}