<?php
// app/Notifications/PropertyCreatedNotification.php

namespace App\Notifications;

use App\Models\Property;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PropertyCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected Property $property,
        protected User $bailleur
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nouveau bien mis en location')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Votre client ' . $this->bailleur->name . ' a ajouté un nouveau bien destiné à la location.')
            ->line('**Bien :** ' . $this->property->name)
            ->line('**Type :** ' . $this->property->propertyType->name)
            ->line('**Adresse :** ' . $this->property->full_address)
            ->action('Voir les détails', url('/avocat/bailleurs/' . $this->bailleur->id))
            ->line('Merci de votre confiance.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'property_created',
            'property_id' => $this->property->id,
            'property_name' => $this->property->name,
            'bailleur_id' => $this->bailleur->id,
            'bailleur_name' => $this->bailleur->name,
            'message' => $this->bailleur->name . ' a ajouté un nouveau bien : ' . $this->property->name,
        ];
    }
}